# KSGMS
MAO DIAY NI AMO STYLE.CSS
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap');

:root {
    --bg-dark-obsidian: #050506;
    --bg-card-dark: #0d0d11;
    --bg-card-nested: #14141a;
    --gold-neon: #e2b842;
    --gold-neon-dim: rgba(226, 184, 66, 0.15);
    --gold-glow: rgba(226, 184, 66, 0.45);
    --border-glow: rgba(226, 184, 66, 0.25);
    --border-muted: rgba(255, 255, 255, 0.06);
    --text-muted: #8a8a93;
}

body {
    font-family: 'Inter', sans-serif;
    letter-spacing: -0.01em;
}

/* Custom interactive transitions */
.btn-transition {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Modal scale-up animation */
.modal-animate {
    animation: modalSlideUp 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalSlideUp {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Dark theme custom scrollbars */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: var(--bg-dark-obsidian);
}
::-webkit-scrollbar-thumb {
    background: var(--gold-neon-dim);
    border-radius: 3px;
}
::-webkit-scrollbar-thumb:hover {
    background: var(--gold-neon);
}

/* Stationary Breathing Animation: Physical layouts remain static while the energy pulses subtly */
@keyframes stationary-neon-pulse {
    0% {
        filter: hue-rotate(0deg) brightness(1);
    }
    50% {
        filter: hue-rotate(6deg) brightness(1.15);
    }
    100% {
        filter: hue-rotate(0deg) brightness(1);
    }
}

/* ==========================================================================
   External CSS Automatic UI Overrides (No PHP Changes Needed)
   ========================================================================== */

/* 1. Global Theme Overrides — Pure Obsidian Background with Widely Spaced Clean Waves */
body.bg-slate-50 {
    background-color: var(--bg-dark-obsidian) !important;
    /* Adjusted paths to separate the lines cleanly with beautiful vertical gaps */
    background-image: 
        url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1920 1080' preserveAspectRatio='none'><defs><filter id='neon-glow' x='-30%' y='-30%' width='160%' height='160%'><feGaussianBlur stdDeviation='20' result='blur'/><feMerge><feMergeNode in='blur'/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><g fill='none' filter='url(%23neon-glow)' stroke-linecap='round' opacity='0.85'><path d='M-50,540 Q250,440 550,190 T1250,90 T1950,-110' stroke='%23ff6600' stroke-width='10' /><path d='M-50,610 Q250,510 550,270 T1250,180 T1950,-20' stroke='%23ffffff' stroke-width='5' opacity='0.95' /><path d='M-50,680 Q250,580 550,350 T1250,270 T1950,70' stroke='%2300ffaa' stroke-width='8' opacity='0.8' /><path d='M200,1150 Q650,930 1050,880 T1950,800' stroke='%23ffffff' stroke-width='4' opacity='0.35' /><path d='M350,1170 Q800,890 1250,790 T2000,550' stroke='%2300ffaa' stroke-width='11' opacity='0.55' /><path d='M500,1190 Q950,910 1420,810 T2050,590' stroke='%23ff9900' stroke-width='7' opacity='0.45' /></g></svg>"),
        linear-gradient(180deg, var(--bg-dark-obsidian) 0%, #060609 100%) !important;
    background-size: 100% 100% !important;
    background-repeat: no-repeat !important;
    background-attachment: fixed !important;
    background-position: center center !important;
    color: #f4f4f5 !important;
    animation: stationary-neon-pulse 8s ease-in-out infinite !important;
}

/* 2. Navigation Bar Theme */
nav.bg-white\/80 {
    background-color: rgba(13, 13, 17, 0.8) !important;
    border-color: var(--border-muted) !important;
}
nav a.text-slate-900 {
    color: var(--gold-neon) !important;
    text-shadow: 0 0 10px var(--gold-glow);
}

/* 3. Containers & Dashboard Card Panels */
.bg-white.p-6.rounded-2xl {
    background-color: var(--bg-card-dark) !important;
    border-color: var(--border-muted) !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 1px var(--border-glow) !important;
}

/* 4. Inside Card Sub-headers & Text variables */
h2.text-slate-400, 
div.text-slate-400,
span.text-slate-800 {
    color: var(--text-muted) !important;
}
h2 {
    border-color: var(--border-muted) !important;
}

/* 5. Operation Target Nested Cards */
.bg-slate-50\/70 {
    background-color: var(--bg-card-nested) !important;
    border-color: var(--border-muted) !important;
}
.text-slate-900.font-mono {
    color: #ffffff !important;
}
.text-slate-400.uppercase {
    color: var(--gold-neon) !important;
    opacity: 0.85;
}

/* 6. Current Ledger Grid Table Layout */
.overflow-x-auto.bg-white,
table {
    background-color: var(--bg-card-dark) !important;
    border-color: var(--border-muted) !important;
}
tr.bg-slate-50\/80 {
    background-color: var(--bg-card-nested) !important;
}
tr {
    border-color: var(--border-muted) !important;
}
td.text-slate-900 {
    color: #ffffff !important;
}
td.text-slate-500 {
    color: var(--text-muted) !important;
}
td.text-slate-950 {
    color: var(--gold-neon) !important;
    text-shadow: 0 0 4px rgba(226, 184, 66, 0.2);
}
.divide-slate-100 > :not([hidden]) ~ :not([hidden]) {
    border-color: var(--border-muted) !important;
}

/* Row hover highlight background */
tr.hover\:bg-slate-50\/40:hover {
    background-color: rgba(255, 255, 255, 0.02) !important;
}

/* 7. Badges & Interactive Buttons */
span.bg-slate-100 {
    background-color: var(--bg-card-nested) !important;
    color: var(--gold-neon) !important;
    border: 1px solid var(--gold-neon-dim);
}
span.bg-slate-100.text-slate-800 {
    background-color: var(--gold-neon-dim) !important;
    color: var(--gold-neon) !important;
    border: none;
}
.bg-slate-200 {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

/* 8. Pure Black Glassmorphism Modals with Neon Gold Accent */
.glass-panel,
#signupModal > div,
#loginModal > div {
    background: rgba(10, 10, 12, 0.92) !important;
    backdrop-filter: blur(20px) !important;
    -webkit-backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(226, 184, 66, 0.3) !important;
    box-shadow: 0 0 30px rgba(226, 184, 66, 0.1), inset 0 0 12px rgba(226, 184, 66, 0.05) !important;
}
.glass-panel h3,
#loginModal h3,
#signupModal h3 {
    color: var(--gold-neon) !important;
    text-shadow: 0 0 8px var(--gold-glow);
}
.glass-panel p,
#loginModal p,
#signupModal p {
    color: var(--text-muted) !important;
}

/* Modal Input Box Configurations */
.glass-panel input,
#loginModal input,
#signupModal input {
    background-color: var(--bg-dark-obsidian) !important;
    border-color: var(--border-muted) !important;
    color: #ffffff !important;
}
.glass-panel input:focus,
#loginModal input:focus,
#signupModal input:focus {
    border-color: var(--gold-neon) !important;
    box-shadow: 0 0 8px var(--gold-neon-dim) !important;
}

/* Form Action CTA Buttons */
.glass-panel button[type="submit"],
#loginModal button[type="submit"],
#signupModal button[type="submit"] {
    background-color: var(--gold-neon) !important;
    color: #000000 !important;
    font-weight: 800 !important;
    box-shadow: 0 4px 15px rgba(226, 184, 66, 0.3) !important;
}
.glass-panel button[type="submit"]:hover,
#loginModal button[type="submit"]:hover,
#signupModal button[type="submit"]:hover {
    background-color: #f1ca5c !important;
    box-shadow: 0 4px 25px var(--gold-glow) !important;
}

/* 9. Guest View — Applied matching clean-line spaced layout styling */
.guest-viewport {
    background-color: var(--bg-dark-obsidian) !important;
    background-image: 
        url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1920 1080' preserveAspectRatio='none'><defs><filter id='neon-glow' x='-30%' y='-30%' width='160%' height='160%'><feGaussianBlur stdDeviation='20' result='blur'/><feMerge><feMergeNode in='blur'/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs><g fill='none' filter='url(%23neon-glow)' stroke-linecap='round' opacity='0.85'><path d='M-50,540 Q250,440 550,190 T1250,90 T1950,-110' stroke='%23ff6600' stroke-width='10' /><path d='M-50,610 Q250,510 550,270 T1250,180 T1950,-20' stroke='%23ffffff' stroke-width='5' opacity='0.95' /><path d='M-50,680 Q250,580 550,350 T1250,270 T1950,70' stroke='%2300ffaa' stroke-width='8' opacity='0.8' /><path d='M200,1150 Q650,930 1050,880 T1950,800' stroke='%23ffffff' stroke-width='4' opacity='0.35' /><path d='M350,1170 Q800,890 1250,790 T2000,550' stroke='%2300ffaa' stroke-width='11' opacity='0.55' /><path d='M500,1190 Q950,910 1420,810 T2050,590' stroke='%23ff9900' stroke-width='7' opacity='0.45' /></g></svg>"),
        linear-gradient(180deg, var(--bg-dark-obsidian) 0%, #060609 100%) !important;
    background-size: 100% 100% !important;
    background-repeat: no-repeat !important;
    background-attachment: fixed !important;
    background-position: center center !important;
    animation: stationary-neon-pulse 8s ease-in-out infinite !important;
}
.guest-viewport h1 {
    text-shadow: 0 0 25px rgba(0,0,0,0.9);
}
.guest-viewport h1 span {
    color: var(--gold-neon) !important;
    text-shadow: 0 0 15px var(--gold-glow);
    opacity: 0.9;
}


#snow-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: 9999;
}






