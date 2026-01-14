// Import Three.js modules
import * as THREE from './libs/three.module.js';
import { GLTFLoader } from './libs/GLTFLoader.js';
import { OBJLoader } from './libs/OBJLoader.js';
import { OrbitControls } from './libs/OrbitControls.js';

jQuery(document).ready(function($) {
    'use strict';
    
    // Variables
    var currentVariationId = null;
    var scene, camera, renderer, controls;
    var currentModel = null;
    
    // Move button and overlay to woocommerce-product-gallery__image on page load
    var $galleryImage = $('.woocommerce-product-gallery__image:first');
    var $buttonContainer = $('#wc-3d-viewer-button-container');
    var $overlay = $('#wc-3d-viewer-overlay');
    
    if ($galleryImage.length && $buttonContainer.length && $overlay.length) {
        // Make gallery image position relative
        if ($galleryImage.css('position') === 'static') {
            $galleryImage.css('position', 'relative');
        }
        
        // Append button and overlay to gallery image
        $galleryImage.append($buttonContainer);
        $galleryImage.append($overlay);
    }
    
    // For simple products or if default model exists, show button on load
    if (!wc3dViewer.is_variable && wc3dViewer.product_3d) {
        // Simple product with 3D model
        showViewerButton();
    } else if (wc3dViewer.is_variable && wc3dViewer.product_3d) {
        // Variable product with default model - show until variation selected
        showViewerButton();
    }
    
    /**
     * Initialize 3D viewer when variation is selected
     */
    $(document).on('found_variation', function(event, variation) {
        currentVariationId = variation.variation_id;
        
        // Check if this variation has a 3D model
        if (wc3dViewer.variations_3d && wc3dViewer.variations_3d[currentVariationId]) {
            showViewerButton();
            
            // If 3D viewer is already open, reload with new model
            if ($('#wc-3d-viewer-overlay').is(':visible')) {
                var modelData = wc3dViewer.variations_3d[currentVariationId];
                // Clean up current viewer
                cleanupViewer();
                // Load new model
                setTimeout(function() {
                    init3DViewer(modelData);
                }, 100);
            }
        } else if (wc3dViewer.product_3d) {
            // No variation model, but default product model exists
            showViewerButton();
            // If viewer is open, reload with default model
            if ($('#wc-3d-viewer-overlay').is(':visible')) {
                cleanupViewer();
                setTimeout(function() {
                    init3DViewer(wc3dViewer.product_3d);
                }, 100);
            }
        } else {
            hideViewerButton();
            // If 3D viewer is open and new variation has no model, close it
            if ($('#wc-3d-viewer-overlay').is(':visible')) {
                close3DViewer();
            }
        }
    });
    
    /**
     * Reset when variation is cleared
     */
    $(document).on('reset_data', function() {
        currentVariationId = null;
        
        // If default product model exists, show button and reload if viewer is open
        if (wc3dViewer.product_3d) {
            showViewerButton();
            if ($('#wc-3d-viewer-overlay').is(':visible')) {
                cleanupViewer();
                setTimeout(function() {
                    init3DViewer(wc3dViewer.product_3d);
                }, 100);
            }
        } else {
            hideViewerButton();
            // Close viewer if open
            if ($('#wc-3d-viewer-overlay').is(':visible')) {
                close3DViewer();
            }
        }
    });
    
    /**
     * Show 3D viewer button
     */
    function showViewerButton() {
        $('#wc-3d-viewer-button-container').show();
    }
    
    /**
     * Hide 3D viewer button
     */
    function hideViewerButton() {
        $('#wc-3d-viewer-button-container').hide();
    }
    
    /**
     * Open 3D viewer on top of product image
     */
    $(document).on('click', '#wc-3d-viewer-button', function(e) {
        e.preventDefault();
        
        var modelData = null;
        
        // Check for variation model first
        if (currentVariationId && wc3dViewer.variations_3d && wc3dViewer.variations_3d[currentVariationId]) {
            modelData = wc3dViewer.variations_3d[currentVariationId];
        } 
        // Fall back to product-level model (simple product or default for variable)
        else if (wc3dViewer.product_3d) {
            modelData = wc3dViewer.product_3d;
        }
        
        if (!modelData) {
            return;
        }
        
        // Hide the button when opening viewer
        $('#wc-3d-viewer-button-container').hide();
        
        $('#wc-3d-viewer-overlay').fadeIn(300);
        
        // Initialize 3D viewer
        setTimeout(function() {
            init3DViewer(modelData);
        }, 100);
    });
    
    /**
     * Close 3D viewer
     */
    $(document).on('click', '#wc-3d-close-btn', function(e) {
        e.preventDefault();
        close3DViewer();
    });
    
    /**
     * Close on ESC key
     */
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27 && $('#wc-3d-viewer-overlay').is(':visible')) {
            close3DViewer();
        }
    });
    
    /**
     * Initialize Three.js 3D viewer
     */
    function init3DViewer(modelData) {
        var container = document.getElementById('wc-3d-viewer-container');
        
        if (!container) {
            console.error('Container not found');
            return;
        }
        
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
        controls = new OrbitControls(camera, renderer.domElement);
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
        console.log('Loading model:', url, 'Format:', extension);
        
        if (extension === 'glb' || extension === 'gltf') {
            loadGLTFModel(url);
        } else if (extension === 'obj') {
            loadOBJModel(url);
        } else {
            console.error('Unsupported 3D format:', extension);
            showError('Unsupported 3D file format: ' + extension);
        }
    }
    
    /**
     * Load GLTF/GLB model
     */
    function loadGLTFModel(url) {
        var loader = new GLTFLoader();
        
        loader.load(
            url,
            function(gltf) {
                currentModel = gltf.scene;
                scene.add(currentModel);
                centerAndScaleModel(currentModel);
                console.log('GLTF model loaded successfully');
            },
            function(xhr) {
                var percent = (xhr.loaded / xhr.total * 100).toFixed(0);
                console.log(percent + '% loaded');
            },
            function(error) {
                console.error('Error loading GLTF model:', error);
                showError('Failed to load 3D model');
            }
        );
    }
    
    /**
     * Load OBJ model
     */
    function loadOBJModel(url) {
        var loader = new OBJLoader();
        
        loader.load(
            url,
            function(obj) {
                currentModel = obj;
                
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
                centerAndScaleModel(currentModel);
                console.log('OBJ model loaded successfully');
            },
            function(xhr) {
                var percent = (xhr.loaded / xhr.total * 100).toFixed(0);
                console.log(percent + '% loaded');
            },
            function(error) {
                console.error('Error loading OBJ model:', error);
                showError('Failed to load 3D model');
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
     * Show error message
     */
    function showError(message) {
        var container = document.getElementById('wc-3d-viewer-container');
        if (container) {
            container.innerHTML = '<div class="wc-3d-error">' + message + '</div>';
        }
    }
    
    /**
     * Clean up viewer resources without closing overlay
     */
    function cleanupViewer() {
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
        
        var container = document.getElementById('wc-3d-viewer-container');
        if (container) {
            container.innerHTML = '';
        }
    }
    
    /**
     * Close 3D viewer
     */
    function close3DViewer() {
        $('#wc-3d-viewer-overlay').fadeOut(300);
        
        // Clean up
        cleanupViewer();
        
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
        
        // Show button again after closing if there's a model available
        if (currentVariationId && wc3dViewer.variations_3d && wc3dViewer.variations_3d[currentVariationId]) {
            $('#wc-3d-viewer-button-container').show();
        } else if (!wc3dViewer.is_variable && wc3dViewer.product_3d) {
            $('#wc-3d-viewer-button-container').show();
        } else if (wc3dViewer.is_variable && wc3dViewer.product_3d && !currentVariationId) {
            $('#wc-3d-viewer-button-container').show();
        }
    }
});
