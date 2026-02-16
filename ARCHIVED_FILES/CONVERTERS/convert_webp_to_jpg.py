#!/usr/bin/env python3
import os
import sys
from pathlib import Path

try:
    from PIL import Image
except ImportError:
    print("Installing Pillow...")
    os.system("pip install pillow -q")
    from PIL import Image

folder = sys.argv[1] if len(sys.argv) > 1 else "toto"
directory = f"public/images/products/{folder}"

if not os.path.isdir(directory):
    print(f"Error: Folder not found - {directory}")
    sys.exit(1)

print(f"Converting WebP to JPG in: {directory}")

webp_files = list(Path(directory).glob("*.webp"))

if not webp_files:
    print(f"No WebP files found in {directory}")
    sys.exit(0)

converted = 0
failed = 0

for webp_file in webp_files:
    try:
        jpg_file = webp_file.with_suffix('.jpg')
        filename = webp_file.name
        
        # Open WebP and convert to JPG
        image = Image.open(str(webp_file)).convert('RGB')
        image.save(str(jpg_file), 'JPEG', quality=85)
        
        # Delete WebP file
        webp_file.unlink()
        
        print(f"✓ Converted: {filename}")
        converted += 1
        
    except Exception as e:
        print(f"✗ Failed to convert: {webp_file.name} - {str(e)}")
        failed += 1

print(f"\nConversion completed!")
print(f"Converted: {converted} files")
if failed > 0:
    print(f"Failed: {failed} files")

sys.exit(0)
