import os
import re

state_path = 'public/state.js'
if os.path.exists(state_path):
    with open(state_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Bump STORAGE_KEY again to force reload
    content = re.sub(r"const STORAGE_KEY = 'restoran_gold_state_v\d+';", "const STORAGE_KEY = 'restoran_gold_state_v6';", content)

    # Regex to capture the broken pieces
    # Broken format:
    # {id:1,https://image.pollinations.ai/prompt/...nologo=trueimg:' category:'Burger', name:'Klasik Burger', price:180, &seed=1', desc:...
    
    def fix_replacer(match):
        id_str = match.group(1)
        url = match.group(2)
        middle = match.group(3)
        return f"{{id:{id_str},{middle}img:'{url}&seed={id_str}',"

    # Match exact broken structure
    content = re.sub(r"\{id:(\d+),(https://image\.pollinations\.ai.*?)img:'(.*?)&seed=\d+',", fix_replacer, content)

    with open(state_path, 'w', encoding='utf-8') as f:
        f.write(content)
