import os
import re
import urllib.parse

html_files = [
    'public/customer.html',
    'public/admin.html',
    'public/waiter.html',
    'public/kitchen.html'
]

root_replacement = """  :root{
    --bg-gradient: #1a1208;
    --surface: rgba(255, 248, 235, 0.07);
    --surface-solid: #1a1208;
    --border: rgba(214, 168, 79, 0.25);
    --primary: #d6a84f;
    --primary-hover: #b8860b;
    --primary-light: rgba(214, 168, 79, 0.15);
    --text: #f5e8cc;
    --muted: #a08050;
    --radius: 20px;
    --shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    --gold-glow: 0 0 20px rgba(214, 168, 79, 0.3);
    --secondary: #2C6B9E;
    --success: #366A38;
    --warning: #B22222;
  }"""

for fpath in html_files:
    if os.path.exists(fpath):
        with open(fpath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace :root
        content = re.sub(r':root\s*\{[^}]+\}', root_replacement, content, count=1)
        
        # Replace hardcoded whites
        content = content.replace('rgba(255,255,255,0.92)', 'rgba(26,18,8,0.92)')
        content = content.replace('rgba(255, 255, 255, 0.95)', 'rgba(26,18,8,0.95)')
        content = content.replace('rgba(255,255,255,0.95)', 'rgba(26,18,8,0.95)')
        content = content.replace('rgba(255,255,255,0.3)', 'rgba(214,168,79,0.1)')
        content = content.replace('rgba(255,255,255,0.4)', 'rgba(214,168,79,0.2)')
        content = content.replace('rgba(255,255,255,0.7)', 'rgba(26,18,8,0.7)')
        content = content.replace('rgba(255,255,255,0.85)', 'rgba(26,18,8,0.85)')
        content = content.replace('#FFFDF8', 'rgba(255, 248, 235, 0.05)')
        content = content.replace('#EEE', '#2a1e08')
        
        # Replace button text #FFF to #1a1208
        content = content.replace('color:#FFF', 'color:#1a1208')
        
        # Fix btn-danger color
        content = content.replace('background:linear-gradient(135deg,#E58F65,#B22222);color:#1a1208', 'background:var(--warning);color:#FFF')
        content = content.replace('background:#B22222;color:#1a1208', 'background:var(--warning);color:#FFF')
        content = content.replace('background:linear-gradient(135deg,var(--success),#2E5A30);color:#1a1208', 'background:linear-gradient(135deg,var(--success),#2E5A30);color:#FFF')
        content = content.replace('background:#2E5A30;color:#1a1208', 'background:#2E5A30;color:#FFF')
        content = content.replace('color:var(--success)', 'color:#4caf7d')
        
        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(content)

# Fix images in state.js
state_path = 'public/state.js'
if os.path.exists(state_path):
    with open(state_path, 'r', encoding='utf-8') as f:
        state_content = f.read()

    def img_replacer(match):
        name = match.group(1)
        price = match.group(2)
        prompt = urllib.parse.quote(f"delicious {name} dark moody lighting, food photography, high end luxury restaurant, highly detailed, photorealistic")
        url = f"https://image.pollinations.ai/prompt/{prompt}?width=600&height=400&nologo=true"
        return f"name:'{name}', price:{price}, img:'{url}'"

    state_content = re.sub(r"name:'([^']+)',\s*price:([^,]+),\s*img:'https://loremflickr.com/[^']+'", img_replacer, state_content)
    
    with open(state_path, 'w', encoding='utf-8') as f:
        f.write(state_content)
