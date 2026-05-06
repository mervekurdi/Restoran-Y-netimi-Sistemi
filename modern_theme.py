import os
import re

html_files = [
    'public/customer.html',
    'public/admin.html',
    'public/waiter.html',
    'public/kitchen.html'
]

root_replacement = """  :root {
    --bg-gradient: #0F172A;
    --surface: #1E293B;
    --surface-solid: #1E293B;
    --border: #334155;
    --primary: #F59E0B;
    --primary-hover: #D97706;
    --primary-light: rgba(245, 158, 11, 0.15);
    --text: #F8FAFC;
    --muted: #94A3B8;
    --radius: 16px;
    --shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    --gold-glow: 0 0 20px rgba(245, 158, 11, 0.2);
    --secondary: #3B82F6;
    --success: #10B981;
    --warning: #EF4444;
  }"""

for fpath in html_files:
    if os.path.exists(fpath):
        with open(fpath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace :root
        content = re.sub(r':root\s*\{[^}]+\}', root_replacement, content, count=1)
        
        # Modernize specific hardcoded colors
        content = content.replace('rgba(26,18,8,0.92)', 'rgba(15, 23, 42, 0.85)')
        content = content.replace('rgba(26,18,8,0.95)', 'rgba(15, 23, 42, 0.95)')
        content = content.replace('rgba(214,168,79,0.1)', 'rgba(255, 255, 255, 0.05)')
        content = content.replace('rgba(214,168,79,0.2)', 'rgba(255, 255, 255, 0.08)')
        content = content.replace('rgba(26,18,8,0.7)', 'rgba(15, 23, 42, 0.7)')
        content = content.replace('rgba(26,18,8,0.85)', 'rgba(15, 23, 42, 0.85)')
        content = content.replace('rgba(255, 248, 235, 0.05)', 'rgba(255, 255, 255, 0.05)')
        content = content.replace('#2a1e08', '#0F172A')
        content = content.replace('#1a1208', '#0F172A')
        
        # Simplify gradients to solid primary colors for a flatter, modern look
        content = content.replace('linear-gradient(135deg,#DFB13E,#B8860B)', 'var(--primary)')
        content = content.replace('linear-gradient(135deg,#B8860B,#8A6412)', 'var(--primary-hover)')
        content = content.replace('linear-gradient(135deg,rgba(223,177,62,0.3),rgba(184,134,11,0.15))', 'var(--primary-light)')
        
        content = content.replace('linear-gradient(135deg,var(--success),#2E5A30)', 'var(--success)')
        content = content.replace('#2E5A30', 'var(--success)')
        
        # Fix border active state in Waiter panel
        content = content.replace('linear-gradient(135deg,rgba(44,107,158,0.05),var(--surface-solid))', 'var(--surface-solid)')
        content = content.replace('linear-gradient(135deg,rgba(54,106,56,0.05),var(--surface-solid))', 'var(--surface-solid)')
        
        # Change Playfair Display to Inter or Poppins for a more modern UI feel
        content = content.replace("font-family:'Playfair Display',serif", "font-family:'Poppins',sans-serif")
        
        # Adjust button text color if they are hardcoded to dark
        # The primary buttons should have dark text because the primary color is Amber (#F59E0B) which is bright.
        content = content.replace('color:#0F172A', 'color:#0F172A; font-weight:700;')
        
        # Minor aesthetic adjustments
        content = content.replace('border-radius:20px', 'border-radius:16px')
        content = content.replace('border-radius:24px', 'border-radius:16px')
        content = content.replace('border-radius:30px', 'border-radius:12px')
        
        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(content)

# We should also modernize resources/views/layouts/app.blade.php to match this!
app_blade = 'resources/views/layouts/app.blade.php'
if os.path.exists(app_blade):
    with open(app_blade, 'r', encoding='utf-8') as f:
        content = f.read()
    
    app_root_replacement = """        :root {
            --clr-bg:        #0F172A;
            --clr-surface:   #1E293B;
            --clr-glass:     rgba(30, 41, 59, 0.7);
            --clr-border:    #334155;
            --clr-gold:      #F59E0B;
            --clr-gold-dark: #D97706;
            --clr-gold-light:rgba(245, 158, 11, 0.15);
            --clr-text:      #F8FAFC;
            --clr-text-mute: #94A3B8;
            --clr-danger:    #EF4444;
            --clr-success:   #10B981;
            --clr-warn:      #F59E0B;
            --radius-sm:     8px;
            --radius-md:     12px;
            --radius-lg:     16px;
            --shadow-sm:     0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md:     0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg:     0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition:    0.2s ease-in-out;
        }"""
    
    content = re.sub(r':root\s*\{[^}]+\}', app_root_replacement, content, count=1)
    
    # Clean up weird radial gradients and backgrounds
    content = re.sub(r'radial-gradient\([^;]+;', '#0F172A;', content)
    content = content.replace('rgba(20, 12, 2, 0.75)', 'rgba(15, 23, 42, 0.85)')
    content = content.replace('linear-gradient(135deg, var(--clr-gold), var(--clr-gold-dark))', 'var(--clr-gold)')
    content = content.replace('color: #1a1208', 'color: #0F172A')
    
    with open(app_blade, 'w', encoding='utf-8') as f:
        f.write(content)
