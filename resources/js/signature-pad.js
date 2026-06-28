/**
 * Signature pad sederhana pakai <canvas>, untuk Digital Signature
 * Validator Desa (Phase 4). Dipanggil dari Blade lewat:
 *
 *   <div x-data="signaturePad()" x-init="init($refs.canvas)">
 *     <canvas x-ref="canvas" ...></canvas>
 *     <input type="hidden" name="signature" x-model="dataUrl">
 *     <button @click="clear()">Hapus</button>
 *   </div>
 */
export function signaturePad() {
  return {
    dataUrl: '',
    canvas: null,
    ctx: null,
    drawing: false,

    init(canvasEl) {
      this.canvas = canvasEl;
      this.ctx = canvasEl.getContext('2d');
      this.ctx.lineWidth = 2.5;
      this.ctx.lineCap = 'round';
      this.ctx.strokeStyle = '#0f172a';

      const start = (event) => {
        this.drawing = true;
        const { x, y } = this.position(event);
        this.ctx.beginPath();
        this.ctx.moveTo(x, y);
      };

      const move = (event) => {
        if (!this.drawing) return;
        const { x, y } = this.position(event);
        this.ctx.lineTo(x, y);
        this.ctx.stroke();
      };

      const end = () => {
        if (!this.drawing) return;
        this.drawing = false;
        this.dataUrl = this.canvas.toDataURL('image/png');
      };

      canvasEl.addEventListener('mousedown', start);
      canvasEl.addEventListener('mousemove', move);
      canvasEl.addEventListener('mouseup', end);
      canvasEl.addEventListener('mouseleave', end);

      canvasEl.addEventListener('touchstart', (e) => { e.preventDefault(); start(e.touches[0]); });
      canvasEl.addEventListener('touchmove', (e) => { e.preventDefault(); move(e.touches[0]); });
      canvasEl.addEventListener('touchend', end);
    },

    position(event) {
      const rect = this.canvas.getBoundingClientRect();
      return { x: event.clientX - rect.left, y: event.clientY - rect.top };
    },

    clear() {
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      this.dataUrl = '';
    },

    get isEmpty() {
      return this.dataUrl === '';
    },
  };
}
