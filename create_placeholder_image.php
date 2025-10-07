<?php

/**
 * Create Placeholder Image for Facilities
 */

echo "🖼️ CREATING PLACEHOLDER IMAGE\n";
echo "=============================\n\n";

// Create placeholder image using GD
function createPlaceholderImage($width = 800, $height = 600, $text = 'Fasilitas Sekolah') {
    // Create image
    $image = imagecreate($width, $height);
    
    // Define colors (blue theme)
    $background = imagecolorallocate($image, 30, 64, 175); // Blue background
    $textColor = imagecolorallocate($image, 255, 255, 255); // White text
    $borderColor = imagecolorallocate($image, 59, 130, 246); // Lighter blue border
    
    // Fill background
    imagefill($image, 0, 0, $background);
    
    // Add border
    imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);
    imagerectangle($image, 5, 5, $width-6, $height-6, $borderColor);
    
    // Add text
    $fontSize = 5;
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $textHeight = imagefontheight($fontSize);
    
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($image, $fontSize, $x, $y, $text, $textColor);
    
    // Add icon (simple building representation)
    $iconSize = 60;
    $iconX = $width / 2 - $iconSize / 2;
    $iconY = $height / 2 - $iconSize - 30;
    
    // Draw simple building icon
    imagerectangle($image, $iconX, $iconY, $iconX + $iconSize, $iconY + $iconSize, $textColor);
    imagerectangle($image, $iconX + 10, $iconY + 10, $iconX + 25, $iconY + 25, $textColor);
    imagerectangle($image, $iconX + 35, $iconY + 10, $iconX + 50, $iconY + 25, $textColor);
    imagerectangle($image, $iconX + 10, $iconY + 35, $iconX + 25, $iconY + 50, $textColor);
    imagerectangle($image, $iconX + 35, $iconY + 35, $iconX + 50, $iconY + 50, $textColor);
    
    return $image;
}

// Create main placeholder
$placeholderImage = createPlaceholderImage(800, 600, 'Fasilitas Sekolah');

// Save as JPEG
$placeholderPath = 'public/images/default-facility.jpg';
if (imagejpeg($placeholderImage, $placeholderPath, 90)) {
    echo "✅ Created: $placeholderPath\n";
} else {
    echo "❌ Failed to create: $placeholderPath\n";
}

// Create thumbnail version
$thumbnailImage = createPlaceholderImage(400, 300, 'Fasilitas');
$thumbnailPath = 'public/images/default-facility-thumb.jpg';
if (imagejpeg($thumbnailImage, $thumbnailPath, 90)) {
    echo "✅ Created: $thumbnailPath\n";
} else {
    echo "❌ Failed to create: $thumbnailPath\n";
}

// Clean up memory
imagedestroy($placeholderImage);
imagedestroy($thumbnailImage);

// Create CSS for better image handling
$imageCSS = '
/* Enhanced Image Handling */
.facility-image-custom {
    position: relative !important;
    overflow: hidden !important;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
}

.facility-image-custom img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.5s ease !important;
    display: block !important;
}

.facility-image-custom img.error {
    display: none !important;
}

.facility-placeholder-custom {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: white !important;
    font-size: 3rem !important;
}

.facility-placeholder-custom i {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)) !important;
}

/* Loading state */
.facility-image-loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%) !important;
    background-size: 200% 100% !important;
    animation: loading 1.5s infinite !important;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
';

file_put_contents('public/css/image-enhancements.css', $imageCSS);
echo "✅ Created: public/css/image-enhancements.css\n";

echo "\n🎉 PLACEHOLDER IMAGES CREATED!\n";
echo "==============================\n";

echo "\n📋 FILES CREATED:\n";
echo "- public/images/default-facility.jpg (800x600)\n";
echo "- public/images/default-facility-thumb.jpg (400x300)\n";
echo "- public/css/image-enhancements.css\n";

echo "\n💡 FEATURES:\n";
echo "- Blue theme placeholder images\n";
echo "- Building icon representation\n";
echo "- Fallback for missing images\n";
echo "- Enhanced CSS for image handling\n";
echo "- Loading states and transitions\n";

echo "\n🔧 NEXT STEPS:\n";
echo "1. Images will automatically show if facility images are missing\n";
echo "2. CSS enhancements improve image loading experience\n";
echo "3. Blue theme matches the updated color scheme\n";
echo "4. Responsive design works on all devices\n";