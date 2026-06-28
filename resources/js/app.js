import Alpine from 'alpinejs';
import { signaturePad } from './signature-pad';

Alpine.data('signaturePad', signaturePad);

/**
 * Dark mode store global, dipakai lewat x-data="{ ...dark mode toggle... }"
 * di navbar & halaman login. Disimpan di localStorage supaya preferensi
 * bertahan antar sesi (mirip next-themes di versi Next.js sebelumnya).
 */
Alpine.store('theme', {
  dark: localStorage.getItem('sik-ampel-theme') === 'dark' ||
    (!localStorage.getItem('sik-ampel-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

  init() {
    this.apply();
  },

  toggle() {
    this.dark = !this.dark;
    localStorage.setItem('sik-ampel-theme', this.dark ? 'dark' : 'light');
    this.apply();
  },

  apply() {
    document.documentElement.classList.toggle('dark', this.dark);
  },
});

Alpine.store('theme').init();

Alpine.store('ui', {
  collapsed: false,
  mobileOpen: false,
  toggleCollapsed() {
    this.collapsed = !this.collapsed;
  },
  openMobile() {
    this.mobileOpen = true;
  },
  closeMobile() {
    this.mobileOpen = false;
  },
});

Alpine.store('toast', {
  visible: false,
  title: '',
  description: '',
  timeoutId: null,
  show(title, description = '') {
    this.title = title;
    this.description = description;
    this.visible = true;
    clearTimeout(this.timeoutId);
    this.timeoutId = setTimeout(() => (this.visible = false), 4000);
  },
});

window.Alpine = Alpine;
Alpine.start();
