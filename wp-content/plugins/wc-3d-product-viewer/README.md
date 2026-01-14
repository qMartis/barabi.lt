# WooCommerce 3D Product Viewer

A WordPress plugin that adds 3D model viewing capability to WooCommerce variable products. Upload 3D models for each product variation and display them interactively on the product page.

## Features

- ✅ **WooCommerce Integration**: Seamlessly integrates with WooCommerce variable products
- ✅ **3D Model Support**: Supports GLB, GLTF, OBJ, FBX, and STL file formats
- ✅ **Per-Variation Models**: Upload unique 3D models for each product variation
- ✅ **Interactive Viewer**: Rotate, zoom, and pan 3D models using Three.js
- ✅ **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- ✅ **Easy to Use**: Simple admin interface for uploading and managing 3D models

## Requirements

- WordPress 5.8 or higher
- WooCommerce 5.0 or higher
- PHP 7.4 or higher

## Installation

1. Upload the `wc-3d-product-viewer` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin will check for WooCommerce and activate automatically

## Usage

### For Administrators

1. **Create/Edit a Variable Product**
   - Go to Products → Add New (or edit existing product)
   - Set Product Data to "Variable product"
   - Add your attributes and create variations

2. **Upload 3D Models to Variations**
   - Scroll to the Variations section
   - Expand a variation you want to add a 3D model to
   - Find the "3D Model" field
   - Click "Upload 3D Model" button
   - Select your 3D model file (GLB, GLTF, OBJ, FBX, or STL)
   - Save the variation

3. **Repeat for Other Variations**
   - Add 3D models to as many variations as you want
   - Each variation can have its own unique 3D model

### For Customers

1. **View Product**
   - Visit a variable product page that has 3D models

2. **Select a Variation**
   - Choose product options (size, color, etc.)
   - If the selected variation has a 3D model, a "View 3D" button will appear in the bottom-right corner of the product image

3. **View 3D Model**
   - Click the "View 3D" button
   - Interactive 3D viewer opens in a modal
   - **Controls:**
     - Drag to rotate the model
     - Scroll/pinch to zoom in/out
     - Right-click drag (or two-finger drag on mobile) to pan

4. **Close Viewer**
   - Click the X button or click outside the viewer
   - Press ESC key to close

## Supported 3D Formats

| Format | Extension | Description |
|--------|-----------|-------------|
| glTF Binary | .glb | Recommended - Best performance and compatibility |
| glTF | .gltf | JSON-based 3D format |
| Wavefront OBJ | .obj | Common 3D format, basic material support |
| Autodesk FBX | .fbx | Industry-standard format |
| STL | .stl | 3D printing format |

**Recommendation**: Use GLB format for best performance and smallest file size.

## File Structure

```
wc-3d-product-viewer/
├── wc-3d-product-viewer.php          # Main plugin file
├── includes/
│   ├── class-wc-3d-viewer-admin.php  # Admin functionality
│   └── class-wc-3d-viewer-frontend.php # Frontend functionality
├── assets/
│   ├── js/
│   │   ├── admin.js                   # Admin JavaScript
│   │   └── frontend.js                # Frontend JavaScript & 3D viewer
│   └── css/
│       ├── admin.css                  # Admin styles
│       └── frontend.css               # Frontend styles
└── README.md                          # This file
```

## Technical Details

### Admin Features
- Custom variation field for 3D model upload
- WordPress Media Library integration
- File format validation
- Visual preview of uploaded models
- Easy removal and replacement of models

### Frontend Features
- Automatic detection of 3D-enabled variations
- Dynamic button positioning
- Three.js-powered 3D rendering
- Orbit controls for model interaction
- Automatic model centering and scaling
- Modal viewer with overlay
- Responsive design for all devices

### 3D Rendering
- Uses Three.js library (v0.160.0)
- GLTFLoader for GLB/GLTF files
- OBJLoader for OBJ files
- OrbitControls for user interaction
- Dynamic lighting setup
- Anti-aliasing enabled
- Hardware acceleration support

## Customization

### Styling the 3D Button

Add custom CSS to your theme:

```css
.wc-3d-viewer-btn {
    background: #your-color !important;
    color: #your-text-color !important;
}
```

### Changing Button Position

Modify the button position in your theme's JavaScript:

```javascript
jQuery('#wc-3d-viewer-button-container').css({
    'bottom': '30px',
    'right': '30px'
});
```

### Custom Modal Size

```css
.wc-3d-modal-content {
    max-width: 1400px !important;
    height: 90vh !important;
}
```

## Troubleshooting

### 3D Button Not Appearing
1. Ensure the product is set as "Variable product"
2. Check that variations are created
3. Verify 3D model is uploaded to the selected variation
4. Clear browser cache

### 3D Model Not Loading
1. Check file format is supported (GLB, GLTF, OBJ, FBX, STL)
2. Verify file uploaded successfully in Media Library
3. Check browser console for errors
4. Ensure file size is reasonable (< 10MB recommended)

### Upload Errors
1. Check PHP upload_max_filesize setting
2. Verify post_max_size is sufficient
3. Check file permissions on uploads folder

## Browser Compatibility

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Tips

1. **Optimize 3D Models**: Keep polygon count reasonable (< 50k triangles)
2. **Use GLB Format**: Better compression and faster loading
3. **Compress Textures**: Use optimized texture sizes
4. **Test File Sizes**: Keep models under 10MB for best performance

## Security

- File type validation on upload
- MIME type checking
- WordPress nonce verification
- Capability checks for admin functions
- Sanitized input/output

## Support & Development

For issues, feature requests, or contributions:
- Check WordPress and WooCommerce compatibility
- Clear cache after updates
- Test in a staging environment first

## Changelog

### Version 1.0.0
- Initial release
- Support for GLB, GLTF, OBJ, FBX, STL formats
- Interactive 3D viewer with Three.js
- Responsive design
- Per-variation 3D model upload
- Admin interface for model management

## License

This plugin follows WordPress coding standards and GPL licensing.

## Credits

- Built with [Three.js](https://threejs.org/)
- Designed for WooCommerce
- Compatible with WordPress standards
