# 🛡️ CFCC Arena: AI Design & Coding Guide

Use the following prompts to ensure all new components, pages, and assets match the **Neo-Brutalist / Tactile Game** style of the MyArena theme.

---

## 1. The "Visual Soul" (Global Context)
*Copy and paste this into an LLM (Gemini/GPT) before asking it to write code:*

> "I am building a Moodle theme called 'MyArena' for a coding competition. The design style is **Neo-Brutalism**. 
> **Key Characteristics:**
> - **Colors:** Primary Orange (#ff6b00), Deep Black (#1f2937), and Clean White (#fafafa).
> - **Borders:** Thick 4px or 6px solid black borders on EVERYTHING.
> - **Shadows:** Hard, 100% opaque offset shadows (not soft glows). Usually 6px to 12px offset.
> - **Typography:** 'Nunito' for headers (extra bold) and 'Roboto Mono' for anything tech/coding related.
> - **Feel:** Tactile, heavy, high-contrast, and game-like.
> 
> Please use these CSS variables and base classes for consistency:
> - `--arena-orange: #ff6b00;`
> - `--arena-dark: #1f2937;`
> - `.arena-card`: Thick borders + hard shadow.
> - `.btn-tactile`: Push-down animation on click with offset shadow."

---

## 2. Component-Specific Prompts

### A. For a "Mission/Round" Card
> "Create a Bootstrap 4 card in the Arena style. It should represent 'Round 1'. It needs a large number '1' in the corner, a title, a short description, and a 'START BATTLE' button. Use the `.arena-card` class and ensure the button has a physical 'push' effect using CSS `:active`."

### B. For the "Coding Terminal" UI (Quiz Page)
> "Design a CSS layout for a coding question. The question text should be in a white box with a 4px black border. The code input area should look like a dark-mode IDE terminal with a header bar that says 'terminal.exe'. Use #1f2937 for the background and #ff6b00 for syntax highlighting or accents."

### C. For a "Success/Fail" Modal
> "Create a modal popup for a successful code submission. It should be high-contrast. Use a bright green border for success. The button should be a large, tactile 'NEXT ROUND' button. Include a placeholder for a victory SVG mascot."

---

## 3. Image Generation Prompts (Midjourney/DALL-E)
*Use these for icons, mascots, or backgrounds:*

> **Mascot:** "Minimalist vector character of a futuristic robot coder, thick black outlines, flat colors, orange and white, neo-brutalist style, simple shapes, high contrast, isolated on white background --v 6.0"
> 
> **Background:** "Subtle technical grid pattern, light gray lines on #fafafa off-white background, architectural blueprint style, very clean, 4k --tile"
> 
> **Icons:** "Flat 2D vector icon of a [Trophy/Shield/Keyboard], thick 8px black stroke, neo-brutalist style, vibrant orange and yellow, game UI asset, isolated --no shadows"

---

## 4. Coding "Safety" Rules for AI
*Tell the AI these rules to prevent breaking Moodle:*
1. "Always use Moodle's `get_string()` for text, do not hardcode words."
2. "Always use `$OUTPUT->header()` and `$OUTPUT->footer()` in PHP files."
3. "Use Bootstrap 4 utility classes (mr-3, d-flex, py-5) since Moodle 4.x is based on Bootstrap 4."
4. "Prefix all custom CSS classes with `arena-` to avoid conflicts with Moodle's core styles."
