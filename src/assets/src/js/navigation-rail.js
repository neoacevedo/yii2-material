
class NavigationRail extends HTMLElement {
  constructor() {
    super();

    // Crear Shadow DOM para encapsular estilos y evitar conflictos
    this.attachShadow({ mode: 'open' });

    // Estilos CSS (usando tokens de Material 3)
    this.shadowRoot.innerHTML = `
      <style>
        :host {
            display: flex;
            position: fixed;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            background: var(--md-sys-color-surface);
            overflow-y: auto;
            z-index: 8;
        }

        .navigation-rail {
            display: flex;
            flex-direction: column;
            width: 88px;
            margin-top: 20px;
        }

        .navigation-rail ::slotted(.nav-item) {
            width: 80px;
            height: 56px;
            margin: -2px auto 14px;
            padding: 2px;
            color: #333;
            text-decoration: none;
        }
      </style>
      <nav class="navigation-rail">
        <slot name="nav-item">
          <div part="icon"></div>
          <div part="label"></div>
        </slot>
      </nav>
    `;
  }

  connectedCallback() {
    const navItemsSlot = this.shadowRoot.querySelector('slot[name="nav-item"]');

    if (navItemsSlot) { // Verifica que el slot exista
      navItemsSlot.addEventListener('slotchange', () => {
        const navItems = navItemsSlot.assignedNodes();

        navItems.forEach(navItem => {
          const icon = navItem.querySelector('[part="icon"]');
          const label = navItem.querySelector('[part="label"]');

          if (icon) {
            icon.style = `
              position: relative;
              display: flex;
              justify-content: center;
              align-items: center;
              width: 56px;
              height: 32px;
              margin-right: auto;
              margin-bottom: 4px;
              margin-left: auto;
              border-radius: 16px;
              transition-duration: .2s;
              transition-property: transform,opacity;
            `;

            if (navItem.classList.contains('active')) {
              icon.style.backgroundColor = 'var(--md-sys-color-surface-container)';
              icon.style.opacity = 1;
              icon.style.transform = 'scaleX(1)';
            }

            navItem.addEventListener('mouseenter', () => {
              // icon.style.backgroundColor = 'var(--md-sys-color-surface-container-highest)';
              icon.style.fontVariationSettings = '"wght" 600,"opsz" 24';
            });

            navItem.addEventListener('mouseleave', () => {
              if (navItem.classList.contains('active')) {
                icon.style.backgroundColor = 'var(--md-sys-color-surface-container)';
              } else {
                icon.style.backgroundColor = '';
              }
              icon.style.fontVariationSettings = '"wght" 400,"opsz" 24';
            });
          }

          if (label) {
            label.style = `
              font-size: 12px;
              margin-bottom: 4px;
              text-align: center;
              pointer-events: none;
            `;
          }
        });
      });
    } else {
      console.error('No se encontró el slot "nav-item" en el Shadow DOM.');
    }
  }

}

customElements.define('md-navigation-rail', NavigationRail);
