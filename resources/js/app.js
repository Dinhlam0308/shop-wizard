import "./bootstrap";
import { Livewire, Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";
window.Alpine = Alpine;

import intersect from "@alpinejs/intersect";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";
import persist from "@alpinejs/persist";

Alpine.plugin(intersect);
Alpine.plugin(collapse);
Alpine.plugin(focus);
Alpine.plugin(persist);

document.addEventListener("alpine:init", () => {
  // =========================
  // Helpers
  // =========================
  const MB = (n) => n * 1024 * 1024;

  const isImageFile = (file) => file && file.type && file.type.startsWith("image/");

  // =========================
  // Main Image Upload
  // =========================
  Alpine.data("productMainImageUpload", ({ maxMB = 5, initialUrl = null } = {}) => ({
    preview: initialUrl,
    previewIsObjectUrl: false,
    error: "",
    isDragging: false,
    maxBytes: MB(maxMB),

    setError(msg) {
      this.error = msg;
      clearTimeout(this._errTimer);
      this._errTimer = setTimeout(() => (this.error = ""), 3500);
    },

    validate(file) {
      if (!file) return false;

      if (!isImageFile(file)) {
        this.setError("Only image files are allowed.");
        return false;
      }

      if (file.size > this.maxBytes) {
        this.setError(`Image must be <= ${maxMB}MB.`);
        return false;
      }

      return true;
    },

    setPreviewFromFile(file) {
      if (this.previewIsObjectUrl && this.preview) URL.revokeObjectURL(this.preview);
      this.preview = URL.createObjectURL(file);
      this.previewIsObjectUrl = true;

      if (this.$refs.removeMain) this.$refs.removeMain.value = "0";
    },

    onChange(e) {
      const file = e.target.files?.[0];
      if (!file) return;

      if (!this.validate(file)) {
        this.$refs.mainInput.value = "";
        return;
      }

      this.error = "";
      this.setPreviewFromFile(file);
    },

    onDrop(e) {
      this.isDragging = false;
      const file = e.dataTransfer?.files?.[0];
      if (!file) return;

      if (!this.validate(file)) {
        this.$refs.mainInput.value = "";
        return;
      }

      this.$refs.mainInput.files = e.dataTransfer.files;
      this.error = "";
      this.setPreviewFromFile(file);
    },

    clear() {
      if (this.previewIsObjectUrl && this.preview) URL.revokeObjectURL(this.preview);
      this.preview = null;
      this.previewIsObjectUrl = false;
      this.error = "";
      this.$refs.mainInput.value = "";

      // nếu bạn muốn xóa luôn ảnh cũ trên server khi submit
      if (this.$refs.removeMain) this.$refs.removeMain.value = "1";
    },
  }));


  // =========================
  // Gallery Upload (max 5 images)
  // =========================
  Alpine.data("productGalleryUpload", ({ maxMB = 5, maxImages = 5, initial = [] } = {}) => ({
    gallery: (() => {
      const base = Array(maxImages).fill(null);
      (initial || []).slice(0, maxImages).forEach((it, i) => {
        base[i] = {
          url: it.url,
          existing: true,
          id: it.id,
        };
      });
      return base;
    })(),

    error: "",
    isDragging: false,
    maxBytes: MB(maxMB),
    deletedImageIds: [],

    init() {
      this.updateDeletedImages();
    },

    setError(msg) {
      this.error = msg;
      clearTimeout(this._errTimer);
      this._errTimer = setTimeout(() => (this.error = ""), 3500);
    },

    validate(file) {
      if (!file) return false;

      if (!isImageFile(file)) {
        this.setError("Only image files are allowed.");
        return false;
      }

      if (file.size > this.maxBytes) {
        this.setError(`"${file.name}" must be <= ${maxMB}MB.`);
        return false;
      }

      return true;
    },

    openPicker() {
      this.$refs.galleryInput.click();
    },

    updateFileInput() {
      const dt = new DataTransfer();
      this.gallery.forEach((item) => {
        if (item?.file) dt.items.add(item.file); // chỉ gửi file mới
      });
      this.$refs.galleryInput.files = dt.files;
    },

    updateDeletedImages() {
      if (this.$refs.deletedImagesInput) {
        this.$refs.deletedImagesInput.value = JSON.stringify(this.deletedImageIds);
      }
    },

    addFileToFirstEmptySlot(file) {
      const emptyIndex = this.gallery.findIndex((x) => x === null);
      if (emptyIndex === -1) {
        this.setError(`Maximum ${maxImages} images.`);
        return;
      }

      this.gallery[emptyIndex] = {
        url: URL.createObjectURL(file),
        file,
        existing: false,
      };
    },

    setFileToSlot(index, file) {
      // nếu slot đang là ảnh mới -> revoke url cũ
      const cur = this.gallery[index];
      if (cur && !cur.existing && cur.url) URL.revokeObjectURL(cur.url);

      // nếu slot là ảnh existing -> coi như replace: đánh dấu xóa ảnh cũ
      if (cur?.existing && cur.id) this.deletedImageIds.push(cur.id);

      this.gallery[index] = {
        url: URL.createObjectURL(file),
        file,
        existing: false,
      };
    },

    onPick(e) {
      const files = Array.from(e.target.files || []);
      if (!files.length) return;

      let added = 0;
      for (const file of files) {
        if (!this.validate(file)) continue;

        const hasSlot = this.gallery.some((x) => x === null);
        if (!hasSlot) {
          this.setError(`Maximum ${maxImages} images.`);
          break;
        }

        this.addFileToFirstEmptySlot(file);
        added++;
      }

      if (added > 0) this.error = "";
      this.updateFileInput();
      this.updateDeletedImages();
    },

    onDropToSlot(e, index) {
      this.isDragging = false;
      const file = e.dataTransfer?.files?.[0];
      if (!file) return;
      if (!this.validate(file)) return;

      this.error = "";
      this.setFileToSlot(index, file);
      this.updateFileInput();
      this.updateDeletedImages();
    },

    removeImage(index) {
      const item = this.gallery[index];
      if (!item) return;

      if (item.existing && item.id) {
        this.deletedImageIds.push(item.id);
      }

      if (!item.existing && item.url) {
        URL.revokeObjectURL(item.url);
      }

      this.gallery[index] = null;
      this.updateFileInput();
      this.updateDeletedImages();
    },
  }));
});

// ===== helpers =====
const refreshLucide = () => window.lucide?.createIcons?.();

// ===== Alpine init (đưa từ Blade qua đây) =====
document.addEventListener("alpine:init", () => {
  // DarkMode store (dựa vào window.DarkMode bạn vẫn giữ trong Blade)
  Alpine.store("darkMode", {
    isDark: window.DarkMode?.isDark ?? document.documentElement.classList.contains("dark"),
    toggle() {
      window.DarkMode?.toggle?.();
      this.isDark = window.DarkMode?.isDark ?? document.documentElement.classList.contains("dark");
    },
  });

  window.addEventListener("darkModeChanged", (e) => {
    Alpine.store("darkMode").isDark = e.detail.isDark;
  });

  queueMicrotask(() => {
    Alpine.store("darkMode").isDark =
      window.DarkMode?.isDark ?? document.documentElement.classList.contains("dark");
  });

  // Loading button component
  Alpine.data("loadingButton", () => ({
    loading: false,
    handleClick(event) {
      if (this.loading) {
        event.preventDefault();
        event.stopPropagation();
        return false;
      }

      this.loading = true;

      const btn = event.currentTarget;
      btn.classList.add("pointer-events-none", "opacity-70");
      btn.innerHTML = `
        <svg class="animate-spin w-4 h-4 inline-block mr-2 text-current"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10"
                  stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <span data-vi="Đang xử lý..." data-en="Processing..."></span>
      `;
    },
  }));
});

// ===== Livewire events (không import Livewire, chỉ nghe event) =====
document.addEventListener("livewire:navigated", () => {
  refreshLucide();

  // reset loading button
  document.querySelectorAll("button[data-loading]").forEach((btn) => {
    btn.classList.remove("pointer-events-none", "opacity-70");
  });
});

document.addEventListener("DOMContentLoaded", () => {
  refreshLucide();
});

document.addEventListener("livewire:init", () => {
  refreshLucide();

  Livewire.hook("morph.updated", () => {
    refreshLucide();
  });

  Livewire.hook("morph.added", () => {
    refreshLucide();
  });
});

// ===== Cart order form (GLOBAL) =====
window.playPing = () => {
  const ctx = new (window.AudioContext || window.webkitAudioContext)();
  const osc = ctx.createOscillator();
  const gain = ctx.createGain();
  osc.connect(gain);
  gain.connect(ctx.destination);
  osc.type = "sine";
  osc.frequency.setValueAtTime(880, ctx.currentTime);
  gain.gain.setValueAtTime(0.1, ctx.currentTime);
  osc.start();
  osc.stop(ctx.currentTime + 0.15);
};

window.shakeModal = (el) => {
  if (!el) return;
  el.classList.add("animate-shake");
  setTimeout(() => el.classList.remove("animate-shake"), 500);
};

window.cartOrderForm = (initial = [], endpoints = {}) => ({
  // ===== state =====
  items: Array.isArray(initial) ? initial : [],
  showConfirm: false,
  loading: false,
  confirmLoading: false,
  total: 0,
  showRemoveConfirm: false,
  showClearConfirm: false,
  removeLoading: false,
  clearLoading: false,
  pendingRemove: null,

  // endpoints
  stateUrl: endpoints.stateUrl,
  updateUrlBase: endpoints.updateUrlBase,
  removeUrlBase: endpoints.removeUrlBase,
  clearUrl: endpoints.clearUrl,

  askRemove(it) {
    this.pendingRemove = it;
    this.showRemoveConfirm = true;

    this.$nextTick(() => {
      document.getElementById("askRemoveConfirmModal")
        ?.scrollIntoView({ behavior: "smooth", block: "center" });
    });
  },

  async doRemove() {
    if (this.removeLoading || !this.pendingRemove) return;
    this.removeLoading = true;
    try {
      await this.remove(this.pendingRemove); // gọi lại hàm remove cũ của bạn
      this.showRemoveConfirm = false;
      this.pendingRemove = null;
    } finally {
      this.removeLoading = false;
    }
  },

  askClearAll() {
    this.showClearConfirm = true;

    this.$nextTick(() => {
      document.getElementById("askClearConfirmModal")
        ?.scrollIntoView({ behavior: "smooth", block: "center" });
    });
  },

  async doClearAll() {
    if (this.clearLoading) return;
    this.clearLoading = true;
    try {
      await this.clearAll(); // gọi lại hàm clearAll cũ của bạn
      this.showClearConfirm = false;
    } finally {
      this.clearLoading = false;
    }
  },

  // ===== computed =====
  get anyRental() {
    return this.items.some((i) => !!i.is_rental);
  },

  // ===== utils =====
  csrf() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
  },

  async request(url, { method = "GET", body } = {}) {
    const token = this.csrf();
    const res = await fetch(url, {
      method,
      credentials: "same-origin",
      headers: {
        "X-CSRF-TOKEN": token,
        "X-Requested-With": "XMLHttpRequest",
        "Accept": "application/json",
        "Content-Type": "application/json",
      },
      body: body ? JSON.stringify(body) : undefined,
    });

    // Laravel có thể trả HTML nếu lỗi -> cố parse an toàn
    let data = null;
    const ct = res.headers.get("content-type") || "";
    if (ct.includes("application/json")) data = await res.json();
    else data = await res.text();

    if (!res.ok) {
      // 419: CSRF mismatch
      const err = new Error(`HTTP ${res.status}`);
      err.status = res.status;
      err.data = data;
      throw err;
    }

    return data;
  },

  // ===== pricing logic (giữ logic của bạn) =====
  unitPrice(it) {
    const base = Number(it.base_price || it.price || 0);
    return Number((it.is_rental ? base * 2 : base).toFixed(2));
  },

  rentalDays(it) {
    if (!it.is_rental || !it.rental_start_at || !it.rental_end_at) return 0;
    const [ys, ms, ds] = it.rental_start_at.split("-").map(Number);
    const [ye, me, de] = it.rental_end_at.split("-").map(Number);
    const s = new Date(ys, ms - 1, ds);
    const e = new Date(ye, me - 1, de);
    const diff = e - s;
    if (isNaN(diff) || diff < 0) return 0;
    return Math.max(1, Math.floor(diff / 86400000) + 1);
  },

  lineTotal(it) {
    const qty = Number(it.quantity || 0);
    const unit = this.unitPrice(it);
    if (!it.is_rental) return qty * unit;

    const days = this.rentalDays(it) || 1;
    let sum = qty * unit * days;
    if (days >= 3) sum *= 0.7;
    return Number(sum.toFixed(2));
  },

  recalc() {
    this.total = this.items.reduce((s, it) => s + this.lineTotal(it), 0);
  },

  formatMoney(v) {
    return "₫" + Number(v || 0).toLocaleString("vi-VN");
  },

  formatDate(yyyy_mm_dd) {
    if (!yyyy_mm_dd) return "";
    const [y, m, d] = yyyy_mm_dd.split("-");
    return `${d}/${m}/${y}`;
  },

  // ===== init & sync =====
  async init() {
    this.recalc();
    if (this.stateUrl) await this.sync();
  },

  async sync() {
    try {
      const data = await this.request(this.stateUrl, { method: "GET" });
      // expect { items: [...] }
      if (data && Array.isArray(data.items)) {
        this.items = data.items;
      }
      this.recalc();
    } catch (e) {
      alert("Có lỗi xảy ra");
      console.error(e);
    }
  },

  // ===== actions =====
  async inc(it) {
    try {
      const url = this.updateUrlBase.replace("___ID___", it.cart_item_id);
      await this.request(url, {
        method: "PATCH",
        body: {
          quantity: Number(it.quantity) + 1,
          rental_start_at: it.rental_start_at ?? null,
          rental_end_at: it.rental_end_at ?? null,
        },
      });
      await this.sync();
    } catch (e) {
      alert("Có lỗi xảy ra");
      console.error(e);
    }
  },

  async dec(it) {
    try {
      const next = Math.max(1, Number(it.quantity) - 1);
      const url = this.updateUrlBase.replace("___ID___", it.cart_item_id);
      await this.request(url, {
        method: "PATCH",
        body: {
          quantity: next,
          rental_start_at: it.rental_start_at ?? null,
          rental_end_at: it.rental_end_at ?? null,
        },
      });
      await this.sync();
    } catch (e) {
      alert("Có lỗi xảy ra");
      console.error(e);
    }
  },

  async remove(it) {
    try {
      const url = this.removeUrlBase.replace("___ID___", it.cart_item_id);
      await this.request(url, { method: "DELETE" });
      await this.sync();
    } catch (e) {
      alert("Có lỗi xảy ra");
      console.error(e);
    }
  },

  async clearAll() {
    try {
      await this.request(this.clearUrl, { method: "DELETE" });
      await this.sync();
    } catch (e) {
      alert("Có lỗi xảy ra");
      console.error(e);
    }
  },

  async updateDates(it) {
    // chỉ sync khi có is_rental
    if (!it.is_rental) return;
    try {
      const url = this.updateUrlBase.replace("___ID___", it.cart_item_id);
      await this.request(url, {
        method: "PATCH",
        body: {
          quantity: Number(it.quantity),
          rental_start_at: it.rental_start_at ?? null,
          rental_end_at: it.rental_end_at ?? null,
        },
      });
      await this.sync();
    } catch (e) {
      alert("Có lỗi xảy ra");
      console.error(e);
    }
  },

  openOrderConfirm() {
    this.showConfirm = true;

    this.$nextTick(() => {
      document.getElementById("orderConfirmModal")
        ?.scrollIntoView({ behavior: "smooth", block: "center" });
    });
  }

});

Alpine.start();
Livewire.start();
