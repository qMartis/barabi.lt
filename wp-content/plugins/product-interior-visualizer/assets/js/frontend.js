/**
 * Frontend JavaScript
 */

(function($) {
	'use strict';

	class PIVVisualizer {
		constructor() {
			this.container = $('.piv-visualizer-container');
			if (!this.container.length) return;

			this.fileInput = $('#piv-image-upload');
			this.uploadLabel = $('.piv-upload-label');
			this.previewContainer = $('.piv-preview-container');
			this.previewImage = $('.piv-preview-image');
			this.removeBtn = $('.piv-remove-image');
			this.visualizeBtn = $('.piv-visualize-btn');
			this.loadingDiv = $('.piv-loading');
			this.resultContainer = $('.piv-result-container');
			this.tryAgainBtn = $('.piv-try-again-btn');
			this.saveImageBtn = $('.piv-save-image-btn');

			this.selectedFile = null;
			this.productId = this.container.data('product-id');
			this.generatedImageUrl = null;

			this.init();
		}

		init() {
			this.bindEvents();
			this.setupDragDrop();
		}

		bindEvents() {
			this.fileInput.on('change', (e) => this.handleFileSelect(e));
			this.removeBtn.on('click', () => this.removeImage());
			this.visualizeBtn.on('click', () => this.generateVisualization());
			this.tryAgainBtn.on('click', () => this.resetForm());
			this.saveImageBtn.on('click', () => this.saveImage());
		}

		setupDragDrop() {
			this.uploadLabel.on('dragover', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.uploadLabel.addClass('piv-dragging');
			});

			this.uploadLabel.on('dragleave', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.uploadLabel.removeClass('piv-dragging');
			});

			this.uploadLabel.on('drop', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.uploadLabel.removeClass('piv-dragging');

				const files = e.originalEvent.dataTransfer.files;
				if (files.length > 0) {
					this.fileInput[0].files = files;
					this.handleFileSelect({ target: this.fileInput[0] });
				}
			});
		}

		handleFileSelect(e) {
			const file = e.target.files[0];
			
			if (!file) return;

			// Validate file type
			if (!file.type.match('image.*')) {
				alert(pivData.strings.error);
				return;
			}

			// Validate file size (5MB max)
			const maxSize = 5 * 1024 * 1024;
			if (file.size > maxSize) {
				alert('File size must be less than 5MB');
				return;
			}

			this.selectedFile = file;

			// Show preview
			const reader = new FileReader();
			reader.onload = (e) => {
				this.previewImage.attr('src', e.target.result);
				this.uploadLabel.hide();
				this.previewContainer.show();
				this.visualizeBtn.prop('disabled', false);
			};
			reader.readAsDataURL(file);
		}

		removeImage() {
			this.selectedFile = null;
			this.fileInput.val('');
			this.previewImage.attr('src', '');
			this.previewContainer.hide();
			this.uploadLabel.show();
			this.visualizeBtn.prop('disabled', true);
		}

		generateVisualization() {
			if (!this.selectedFile) {
				alert(pivData.strings.selectImage);
				return;
			}

			// Prepare form data
			const formData = new FormData();
			formData.append('action', 'piv_generate_visualization');
			formData.append('nonce', pivData.nonce);
			formData.append('product_id', this.productId);
			formData.append('image', this.selectedFile);

			// Show loading and scroll to product section
			this.visualizeBtn.hide();
			this.loadingDiv.show();
			
			// Scroll to product section
			$('.piv-product-section').get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });

			// Make AJAX request
			$.ajax({
				url: pivData.ajaxUrl,
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: (response) => {
					if (response.success) {
						this.showResult(response.data);
					} else {
						this.handleError(response.data.message);
					}
				},
				error: () => {
					this.handleError(pivData.strings.error);
				}
			});
		}

		showResult(data) {
			this.loadingDiv.hide();
			this.visualizeBtn.show();
			
			// Store generated image URL
			this.generatedImageUrl = data.visualized_image;
			
			// Reset upload section to default
			this.removeImage();
			
			// Replace product image with visualized image
			$('.piv-product-image').attr('src', data.visualized_image);
			
			// Show save button
			this.saveImageBtn.fadeIn();
			
			// Show remaining requests
			if (data.remaining_requests !== undefined) {
				console.log('Remaining requests today:', data.remaining_requests);
			}
		}

		handleError(message) {
			this.loadingDiv.hide();
			this.visualizeBtn.show();
			alert(message || pivData.strings.error);
		}

		resetForm() {
			this.removeImage();
			this.loadingDiv.hide();
			this.visualizeBtn.show();
		}

		saveImage() {
			if (!this.generatedImageUrl) {
				alert('No image to save');
				return;
			}

			// Create a temporary link and trigger download
			const link = document.createElement('a');
			link.href = this.generatedImageUrl;
			link.download = 'visualization-' + Date.now() + '.png';
			document.body.appendChild(link);
			link.click();
			document.body.removeChild(link);
		}
	}

	// Initialize on document ready
	$(document).ready(function() {
		new PIVVisualizer();
	});

})(jQuery);
