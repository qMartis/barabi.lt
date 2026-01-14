jQuery(document).ready(function($) {
    'use strict';
    
    // Variables
    var currentVariationId = null;
    var viewer3D = null;
    var scene, camera, renderer, controls;
    var currentModel = null;
    
    /**
     * Initialize 3D viewer when variation is selected
     */
    $(document).on('found_variation', function(event, variation) {
        currentVariationId = variation.variation_id;
        
        // Check if this variation has a 3D model
        if (wc3dViewer.variations_3d && wc3dViewer.variations_3d[currentVariationId]) {
            showViewerButton();
        } else {
            hideViewerButton();
        }
    });
    
    /**
     * Reset when variation is cleared
     */
    $(document).on('reset_data', function() {
        currentVariationId = null;
        hideViewerButton();
    });
    
    /**
     * Show 3D viewer button
     */
    function showViewerButton() {
        var $buttonContainer = $('#wc-3d-viewer-button-container');
        var $productImages = $('.woocommerce-product-gallery');
        
        if ($buttonContainer.length && $productImages.length) {
            // Position button in bottom right of product image
            $buttonContainer.css({
                'position': 'absolute',
                'bottom': '20px',
                'right': '20px',
                'z-index': '100'
            });
            
            // Make product gallery position relative if not already
            if ($productImages.css('position') === 'static') {
                $productImages.css('position', 'relative');
            }
            
            $buttonContainer.show();
        }
    }
    
    /**
     * Hide 3D viewer button
     */
    function hideViewerButton() {
        $('#wc-3d-viewer-button-container').hide();
    }
    
    /**
     * Open 3D viewer modal
     */
    $(document).on('click', '#wc-3d-viewer-button', function(e) {
        e.preventDefault();
        
        if (!currentVariationId || !wc3dViewer.variations_3d[currentVariationId]) {
            return;
        }
        
        var modelData = wc3dViewer.variations_3d[currentVariationId];
        
        // Show modal
        $('#wc-3d-viewer-modal').fadeIn(300);
        $('body').addClass('wc-3d-modal-open');
        
        // Initialize 3D viewer
        setTimeout(function() {
            init3DViewer(modelData);
        }, 100);
    });
    
    /**
     * Close 3D viewer modal
     */
    $(document).on('click', '.wc-3d-modal-close, .wc-3d-modal-overlay', function(e) {
        e.preventDefault();
        close3DViewer();
    });
    
    /**
     * Close on ESC key
     */
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27 && $('#wc-3d-viewer-modal').is(':visible')) {
            close3DViewer();
        }
    });
    
    /**
     * Initialize Three.js 3D viewer
     */
    function init3DViewer(modelData) {
        var container = document.getElementById('wc-3d-viewer-container');
        
        if (!container) {
            return;
        }
        
        // Clear previous content
        container.innerHTML = '';
        
        // Scene
        scene = new THREE.Scene();
        scene.background = new THREE.Color(0xf0f0f0);
        
        // Camera
        var containerWidth = container.clientWidth;
        var containerHeight = container.clientHeight;
        
        camera = new THREE.PerspectiveCamera(
            45,
            containerWidth / containerHeight,
            0.1,
            1000
        );
        camera.position.set(0, 0, 5);
        
        // Renderer
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(containerWidth, containerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);
        
        // Lights
        var ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
        scene.add(ambientLight);
        
        var directionalLight1 = new THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight1.position.set(1, 1, 1);
        scene.add(directionalLight1);
        
        var directionalLight2 = new THREE.DirectionalLight(0xffffff, 0.4);
        directionalLight2.position.set(-1, -1, -1);
        scene.add(directionalLight2);
        
        // Controls
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.screenSpacePanning = false;
        controls.minDistance = 1;
        controls.maxDistance = 100;
        
        // Load model
        loadModel(modelData.model_url, modelData.extension);
        
        // Handle window resize
        $(window).on('resize.wc3dviewer', function() {
            if (camera && renderer && container) {
                var width = container.clientWidth;
                var height = container.clientHeight;
                
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
                renderer.setSize(width, height);
            }
        });
        
        // Animation loop
        animate();
    }
    
    /**
     * Load 3D model based on format
     */
    function loadModel(url, extension) {
        if (extension === 'glb' || extension === 'gltf') {
            loadGLTFModel(url);
        } else if (extension === 'obj') {
            loadOBJModel(url);
        } else {
            console.error('Unsupported 3D format: ' + extension);
        }
    }
    
    /**
     * Load GLTF/GLB model
     */
    function loadGLTFModel(url) {
        var loader = new THREE.GLTFLoader();
        
        loader.load(
            url,
            function(gltf) {
                currentModel = gltf.scene;
                scene.add(currentModel);
                
                // Center and scale model
                centerAndScaleModel(currentModel);
            },
            function(xhr) {
                console.log((xhr.loaded / xhr.total * 100) + '% loaded');
            },
            function(error) {
                console.error('Error loading GLTF model:', error);
            }
        );
    }
    
    /**
     * Load OBJ model
     */
    function loadOBJModel(url) {
        var loader = new THREE.OBJLoader();
        
        loader.load(
            url,
            function(obj) {
                currentModel = obj;
                
                // Add basic material to OBJ
                currentModel.traverse(function(child) {
                    if (child instanceof THREE.Mesh) {
                        child.material = new THREE.MeshStandardMaterial({
                            color: 0xcccccc,
                            roughness: 0.5,
                            metalness: 0.5
                        });
                    }
                });
                
                scene.add(currentModel);
                
                // Center and scale model
                centerAndScaleModel(currentModel);
            },
            function(xhr) {
                console.log((xhr.loaded / xhr.total * 100) + '% loaded');
            },
            function(error) {
                console.error('Error loading OBJ model:', error);
            }
        );
    }
    
    /**
     * Center and scale model to fit in view
     */
    function centerAndScaleModel(model) {
        var box = new THREE.Box3().setFromObject(model);
        var center = box.getCenter(new THREE.Vector3());
        var size = box.getSize(new THREE.Vector3());
        
        // Center model
        model.position.sub(center);
        
        // Scale model to fit
        var maxDim = Math.max(size.x, size.y, size.z);
        var scale = 2 / maxDim;
        model.scale.multiplyScalar(scale);
        
        // Adjust camera distance
        camera.position.z = maxDim * 1.5;
        controls.update();
    }
    
    /**
     * Animation loop
     */
    function animate() {
        if (!renderer || !scene || !camera) {
            return;
        }
        
        requestAnimationFrame(animate);
        
        if (controls) {
            controls.update();
        }
        
        renderer.render(scene, camera);
    }
    
    /**
     * Close 3D viewer
     */
    function close3DViewer() {
        $('#wc-3d-viewer-modal').fadeOut(300);
        $('body').removeClass('wc-3d-modal-open');
        
        // Clean up
        $(window).off('resize.wc3dviewer');
        
        if (renderer) {
            renderer.dispose();
            renderer = null;
        }
        
        if (scene) {
            scene.traverse(function(object) {
                if (object.geometry) {
                    object.geometry.dispose();
                }
                if (object.material) {
                    if (Array.isArray(object.material)) {
                        object.material.forEach(function(material) {
                            material.dispose();
                        });
                    } else {
                        object.material.dispose();
                    }
                }
            });
            scene = null;
        }
        
        camera = null;
        controls = null;
        currentModel = null;
        
        // Clear container
        var container = document.getElementById('wc-3d-viewer-container');
        if (container) {
            container.innerHTML = '';
        }
    }
});
