class NavigationDrawer extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this._isOpen = false;
        this._type = this.getAttribute('type') || 'modal'; // Default to modal
    }

    static get styles() {
        return /*css*/`
      :host {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        background-color: var(--md-sys-color-surface);
        box-shadow: var(--md-sys-elevation-level-3, 0px 1px 3px 0px rgba(0, 0, 0, 0.12), 0px 2px 6px 2px rgba(0, 0, 0, 0.06));
        z-index: 10;
        transition: transform 0.3s ease-in-out;
      }

      /* Estilos comunes a ambos modos */
      .drawer {
        display: flex;
        flex-direction: column;
        height: 100%;
      }

      .drawer-header {
        padding: 16px;
        border-bottom: 1px solid var(--md-sys-color-outline);
      }

      .drawer-title {
        font-family: 'Roboto', sans-serif;
        font-size: 1.25rem;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin: 0;
      }

      .drawer-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
      }

      .drawer-list-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        cursor: pointer;
        text-decoration: none;
        color: var(--md-sys-color-on-surface);
      }

      .drawer-list-item:hover {
        background-color: rgba(var(--md-sys-color-primary-rgb, 103, 80, 164), 0.08);
      }

      .drawer-list-item.active {
        background-color: rgba(var(--md-sys-color-primary-rgb, 103, 80, 164), 0.16);
        color: var(--md-sys-color-primary);
      }

      .drawer-list-item .item-icon {
        margin-right: 16px;
      }

      .drawer-list-item .item-text {
        font-family: 'Roboto', sans-serif;
        font-size: 1rem;
        font-weight: 400;
      }

      /* Estilos específicos para el modo modal */
      :host([mode="modal"]) {
        width: 300px; /* Ancho típico para modal */
        transform: translateX(-100%);
      }

      :host([mode="modal"].open) {
        transform: translateX(0);
      }

      .scrim {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0s 0.3s;
        z-index: 9; /* Debajo del drawer modal */
      }

      :host([mode="modal"].open) + .scrim {
        opacity: 1;
        visibility: visible;
        transition: opacity 0.3s ease-in-out, visibility 0s 0s;
      }

      /* Estilos específicos para el modo estándar */
      :host([mode="standard"]) {
        width: 240px; /* Ancho típico para estándar */
        transform: translateX(0); /* Siempre visible */
        border-right: 1px solid var(--md-sys-color-outline);
      }

      :host([mode="standard"]) .drawer-header {
        border-bottom: none; /* Opcional: quitar el borde inferior en modo estándar */
      }
    `;
    }

    connectedCallback() {
        this._type = this.getAttribute('type') || 'modal';
        this.shadowRoot.innerHTML = `
      <style>${NavigationDrawer.styles}</style>
      <div class="drawer">
        <div class="drawer-header">
          <h2 class="drawer-title"><slot name="title">Menú</slot></h2>
        </div>
        <ul class="drawer-list">
          <slot name="content"></slot>
        </ul>
      </div>
      ${this._type === 'modal' ? '<div class="scrim"></div>' : ''}
    `;
        this._drawerElement = this.shadowRoot.querySelector('.drawer');
        if (this._type === 'modal') {
            this._scrimElement = this.shadowRoot.querySelector('.scrim');
            this._scrimElement.addEventListener('click', this._closeDrawer.bind(this));
        }
    }

    disconnectedCallback() {
        if (this._type === 'modal' && this._scrimElement) {
            this._scrimElement.removeEventListener('click', this._closeDrawer.bind(this));
        }
    }

    static get observedAttributes() {
        return ['mode'];
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === 'mode' && oldValue !== newValue) {
            this._type = newValue;
            // Re-render the component to apply the new mode's structure and styles
            this.connectedCallback();
        }
    }

    open() {
        if (this._type === 'modal') {
            this._isOpen = true;
            this.classList.add('open');
            const scrim = this.shadowRoot.querySelector('.scrim');
            if (scrim) {
                scrim.classList.add('open');
            }
            document.body.style.overflow = 'hidden';
        } else if (this._type === 'standard') {
            // En modo estándar, el drawer generalmente está siempre abierto
            console.warn("El método 'open()' no tiene efecto en el modo 'standard'.");
        }
    }

    close() {
        if (this._type === 'modal') {
            this._isOpen = false;
            this.classList.remove('open');
            const scrim = this.shadowRoot.querySelector('.scrim');
            if (scrim) {
                scrim.classList.remove('open');
            }
            document.body.style.overflow = '';
        } else if (this._type === 'standard') {
            // En modo estándar, el drawer generalmente está siempre abierto
            console.warn("El método 'close()' no tiene efecto en el modo 'standard'.");
        }
    }

    _closeDrawer() {
        this.close();
    }

    toggle() {
        if (this._type === 'modal') {
            this._isOpen ? this.close() : this.open();
        } else if (this._type === 'standard') {
            console.warn("El método 'toggle()' no tiene efecto en el modo 'standard'.");
        }
    }
}

customElements.define('md-navigation-drawer', NavigationDrawer);

// Ejemplo de uso:
document.addEventListener('DOMContentLoaded', () => {
    const openModalButton = document.getElementById('openModalDrawer');
    const closeModalButton = document.getElementById('closeModalDrawer');
    const modalDrawer = document.querySelector('md-navigation-drawer[mode="modal"]');

    const standardDrawer = document.querySelector('md-navigation-drawer[mode="standard"]');

    if (openModalButton && modalDrawer) {
        openModalButton.addEventListener('click', () => modalDrawer.open());
    }

    if (closeModalButton && modalDrawer) {
        closeModalButton.addEventListener('click', () => modalDrawer.close());
    }

    // Ejemplo de adición de items (válido para ambos modos)
    const navItems = [
        { text: 'Inicio', icon: 'home' },
        { text: 'Perfil', icon: 'person' },
        { text: 'Configuración', icon: 'settings' },
    ];

    const addItemsToDrawer = (drawerElement) => {
        navItems.forEach(item => {
            const listItem = document.createElement('a');
            listItem.classList.add('drawer-list-item');
            listItem.href = '#';
            listItem.innerHTML = `
        <span class="item-icon">${item.icon}</span>
        <span class="item-text">${item.text}</span>
      `;
            drawerElement.appendChild(listItem);
        });
    };

    if (modalDrawer) {
        addItemsToDrawer(modalDrawer);
    }
    if (standardDrawer) {
        addItemsToDrawer(standardDrawer);
    }
});