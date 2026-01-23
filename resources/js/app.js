import "./bootstrap";

import intersect from "@alpinejs/intersect";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";
import Alpine from "alpinejs";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
Swiper.use([Navigation, Pagination, Autoplay]);


function attachAlpinePlugins(Alpine) {
  Alpine.plugin(intersect);
  Alpine.plugin(collapse);
  Alpine.plugin(focus);
}

function ensureAlpineReady() {
  if (window.Alpine) {
    attachAlpinePlugins(window.Alpine);
    return;
  }

  // If Livewire loads Alpine, wait for it. Otherwise import Alpine ourselves.
  const onReady = () => {
    if (window.Alpine) {
      attachAlpinePlugins(window.Alpine);
      return;
    }

    // Import Alpine dynamically and attach plugins
    import("alpinejs").then((module) => {
      const Alpine = module.default;
      attachAlpinePlugins(Alpine);
      window.Alpine = Alpine;
      if (typeof Alpine.start === "function") {
        Alpine.start();
      }
    });
  };

  document.addEventListener("livewire:load", onReady, { once: true });
  document.addEventListener("DOMContentLoaded", onReady, { once: true });
}

ensureAlpineReady();

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
    this.recalc();
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

document.addEventListener('alpine:init', () => {
  Alpine.data('productVariantsEditor', (cfg) => ({
    hasVariants: Number(cfg?.initialHasVariants ?? 0) === 1,
    variants: Array.isArray(cfg?.initialVariants) ? cfg.initialVariants : [],
    clientError: '',

    init() {
      // normalize data
      this.variants = (this.variants || []).map(v => this.normalize(v));

      // nếu bật variants mà rỗng -> tạo 1 dòng
      if (this.hasVariants && this.variants.length === 0) this.addVariant();

      // nếu tắt variants -> clear error
      if (!this.hasVariants) this.clientError = '';
    },

    setHasVariants(val) {
      this.hasVariants = !!val;
      this.clientError = '';

      if (this.hasVariants && this.variants.length === 0) {
        this.addVariant();
      }
    },

    normalize(v) {
      return {
        color: (v?.color ?? '').toString().trim(),
        size: (v?.size ?? '').toString().trim(),
        price: (v?.price === '' || v?.price === undefined) ? null : (v?.price === null ?
          null : Number(v.price)),
        stock: (v?.stock === '' || v?.stock === undefined || v?.stock === null) ? 0 :
          Number(v.stock),
      };
    },

    addVariant() {
      this.variants.push({
        color: '',
        size: '',
        price: null,
        stock: 0
      });
    },

    removeVariant(idx) {
      this.variants.splice(idx, 1);
      if (this.hasVariants && this.variants.length === 0) this.addVariant();
    },

    get totalStock() {
      return (this.variants || []).reduce((sum, v) => sum + (Number(v.stock) || 0),
        0);
    },

    get variantsJson() {
      if (!this.hasVariants) return '[]';

      const cleaned = (this.variants || []).map(v => this.normalize(v));

      // client validation nhẹ (server vẫn validate chính)
      const seen = new Set();
      for (let i = 0; i < cleaned.length; i++) {
        const v = cleaned[i];

        if (!v.color || !v.size) {
          this.clientError = `Variant #${i + 1}: Color và Size không được trống.`;
          // vẫn return JSON để user không mất data khi submit fail, nhưng báo error
          break;
        }
        if (Number.isNaN(v.stock) || v.stock < 0) {
          this.clientError = `Variant #${i + 1}: Stock phải >= 0.`;
          break;
        }
        if (v.price !== null && (Number.isNaN(v.price) || v.price < 0)) {
          this.clientError = `Variant #${i + 1}: Price phải >= 0 hoặc để trống.`;
          break;
        }

        const key = (v.color + '|' + v.size).toLowerCase();
        if (seen.has(key)) {
          this.clientError = `Duplicate variant: ${v.color} - ${v.size}`;
          break;
        }
        seen.add(key);
      }

      return JSON.stringify(cleaned);
    },
  }));
});

document.addEventListener('alpine:init', () => {
  Alpine.data('productShowPage', (payload) => {
    const clean = (arr) => (Array.isArray(arr) ? arr.filter(Boolean) : []);
    const all = [payload.mainImage, ...clean(payload.gallery)];
    const unique = Array.from(new Set(all));

    const variants = Array.isArray(payload.variants) ? payload.variants : [];
    const hasVariants = variants.length > 0;
    const uniq = (arr) => Array.from(new Set(arr));

    return {
      // gallery
      active: unique[0] || '',
      allImages: unique,

      // variants
      variants,
      hasVariants,
      selectedColor: '',
      selectedSize: '',

      init() {
        if (this.hasVariants) {
          const v0 = this.variants[0];
          this.selectedColor = v0?.color || '';
          this.selectedSize = v0?.size || '';

          // đổi color => auto chọn size hợp lệ
          this.$watch('selectedColor', () => {
            const sizes = this.sizesForSelectedColor;
            if (!sizes.includes(this.selectedSize)) {
              this.selectedSize = sizes[0] || '';
            }
          });
        }
      },

      get colors() {
        if (!this.hasVariants) return [];
        return uniq(this.variants.map(v => v.color).filter(Boolean));
      },

      get sizesForSelectedColor() {
        if (!this.hasVariants) return [];
        return uniq(
          this.variants
            .filter(v => (v.color || '') === this.selectedColor)
            .map(v => v.size)
            .filter(Boolean)
        );
      },

      get selectedVariant() {
        if (!this.hasVariants) return null;
        return this.variants.find(v => v.color === this.selectedColor && v.size === this.selectedSize) || null;
      },

      get displayPrice() {
        if (this.hasVariants) {
          const v = this.selectedVariant;
          if (!v) return payload.basePrice || 0;
          return (v.price === null || v.price === '' || typeof v.price === 'undefined')
            ? (payload.basePrice || 0)
            : Number(v.price) || 0;
        }
        return payload.basePrice || 0;
      },

      get displayStock() {
        if (this.hasVariants) {
          const v = this.selectedVariant;
          return v ? (Number(v.stock) || 0) : 0;
        }
        return payload.baseStock || 0;
      },

      get variantStock() {
        return this.displayStock;
      },

      formatVND(n) {
        const val = Number(n) || 0;
        return new Intl.NumberFormat('vi-VN').format(val) + '₫';
      },

      // toast + lightbox
      toast: { show: false, message: '' },
      lightbox: { open: false, src: '' },

      openLightbox(src) {
        this.lightbox.src = src;
        this.lightbox.open = true;
        document.documentElement.classList.add('overflow-hidden');
      },

      closeLightbox() {
        this.lightbox.open = false;
        this.lightbox.src = '';
        document.documentElement.classList.remove('overflow-hidden');
      },

      async copyText(text) {
        try {
          await navigator.clipboard.writeText(text);
          this.showToast('Copied!');
        } catch (e) {
          this.showToast('Copy failed');
        }
      },

      showToast(message) {
        this.toast.message = message;
        this.toast.show = true;
        clearTimeout(this._t);
        this._t = setTimeout(() => (this.toast.show = false), 1300);
      },
    };
  });
});

document.addEventListener("DOMContentLoaded", () => {
  initMenuSwipers();
});

document.addEventListener("livewire:navigated", () => {
  initMenuSwipers();
});


function initMenuSwipers() {

  // HERO
  const heroEl = document.querySelector(".heroSwiper");
  if (heroEl) {
    // nếu đã init rồi thì destroy trước
    if (heroEl.swiper) heroEl.swiper.destroy(true, true);

    new Swiper(heroEl, {
      // thêm 2 dòng này để chắc chắn nút hoạt động
      navigation: {
        nextEl: heroEl.querySelector(".heroNext"),
        prevEl: heroEl.querySelector(".heroPrev"),
      },
      pagination: { el: heroEl.querySelector(".heroPagination"), clickable: true },

      // thêm để tránh “nút không nghe click” khi overlay che
      watchOverflow: true,
      observer: true,
      observeParents: true,

      loop: true,
      speed: 900,
      effect: "slide",
      autoplay: { delay: 3500, disableOnInteraction: false },
    });
  }

  // FEATURED
  const featuredEl = document.querySelector(".featuredSwiper");
  if (featuredEl) {
    if (featuredEl.swiper) featuredEl.swiper.destroy(true, true);

    new Swiper(featuredEl, {
      loop: true,
      speed: 700,
      spaceBetween: 18,
      pagination: {
        el: featuredEl.querySelector(".featuredPagination"),
        clickable: true,
      },
      breakpoints: {
        0: { slidesPerView: 1.05 },
        480: { slidesPerView: 1.2 },
        640: { slidesPerView: 1.6 },
        1024: { slidesPerView: 2 },   // ✅ đúng yêu cầu: 2 card
        1280: { slidesPerView: 2 },   // ✅ vẫn 2 card
      },
    });
  }
}

document.addEventListener("alpine:init", () => {
  Alpine.data("slugger", ({ initialTitle = "", initialSlug = "" } = {}) => ({
    title: initialTitle || "",
    slug: initialSlug || "",
    slugTouched: !!initialSlug,

    onTitleInput() {
      if (this.slugTouched) return;
      this.slug = this.slugify(this.title);
    },
    forceGenerate() {
      this.slugTouched = false;
      this.slug = this.slugify(this.title);
    },
    slugify(s) {
      return (s || "")
        .toString()
        .normalize("NFKD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, "")
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-");
    },
  }));

  Alpine.data("markdownEditor", ({ initial = "" } = {}) => ({
    tab: "write",
    value: initial || "",

    galleryUrls: Array(4).fill(null),

    previewHtml: "",

    init() {
      this.rebuildPreview();

      this.$watch("value", () => this.rebuildPreview());

      window.addEventListener("news-gallery-changed", (e) => {
        const g = e?.detail?.gallery || [];
        this.galleryUrls = (g || []).slice(0, 4).map((x) => (x ? x.url : null));
        while (this.galleryUrls.length < 4) this.galleryUrls.push(null);

        this.rebuildPreview();
      });
    },

    insertImageCaptionMarker() {
      let n = 1;
      while (n <= 4 && new RegExp(`\\{\\{img:${n}(\\||\\}\\})`).test(this.value)) n++;
      if (n > 4) n = 1;

      this.insertAtCursor(`\n{{img:${n}|cap:Your caption here}}\n`);
    },


    insertAtCursor(text) {
      const ta = this.$refs.ta;
      if (!ta) return;

      const start = ta.selectionStart ?? this.value.length;
      const end = ta.selectionEnd ?? this.value.length;

      this.value = this.value.slice(0, start) + text + this.value.slice(end);

      this.$nextTick(() => {
        ta.focus();
        const pos = start + text.length;
        ta.setSelectionRange(pos, pos);
      });
    },

    rebuildPreview() {
      const esc = (s) =>
        (s || "")
          .replaceAll("&", "&amp;")
          .replaceAll("<", "&lt;")
          .replaceAll(">", "&gt;");

      let s = esc(this.value);

      s = s.replace(/\{\{img:(\d)(\|cap:([^}]+))?\}\}/g, (_m, d, _capPart, capText) => {
        const idx = parseInt(d, 10) - 1;
        const url = this.galleryUrls[idx];

        if (!url) {
          return `
      <div class="my-3 p-3 rounded-lg border border-dashed text-xs text-gray-500 dark:text-gray-300">
        (Image ${d} not selected yet)
      </div>
    `;
        }

        const cap = (capText || "").trim();
        const capHtml = cap
          ? `<figcaption class="mt-2 text-center text-[12px] leading-5 text-gray-500 dark:text-gray-300 italic">
         ${cap.replaceAll("&", "&amp;").replaceAll("<", "&lt;").replaceAll(">", "&gt;")}
       </figcaption>`
          : "";

        return `
    <figure class="my-4">
      <img src="${url}" alt="Gallery ${d}" class="w-full rounded-xl shadow-md"/>
      ${capHtml}
    </figure>
  `;
      });

      s = s
        .replace(/^###### (.*)$/gm, "<h6>$1</h6>")
        .replace(/^##### (.*)$/gm, "<h5>$1</h5>")
        .replace(/^#### (.*)$/gm, "<h4>$1</h4>")
        .replace(/^### (.*)$/gm, "<h3>$1</h3>")
        .replace(/^## (.*)$/gm, "<h2>$1</h2>")
        .replace(/^# (.*)$/gm, "<h1>$1</h1>")
        .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
        .replace(/\*(.*?)\*/g, "<em>$1</em>")
        .replace(/`([^`]+)`/g, "<code>$1</code>")
        .replace(/^\> (.*)$/gm, "<blockquote>$1</blockquote>")
        .replace(/^\- (.*)$/gm, "<li>$1</li>")
        .replace(/(<li>.*<\/li>\n?)+/g, (m) => `<ul>${m}</ul>`)
        .replace(/\n/g, "<br/>");

      this.previewHtml = s;
    },

    wrap(left, right) {
      const ta = this.$refs.ta;
      const start = ta.selectionStart, end = ta.selectionEnd;
      const selected = this.value.slice(start, end);
      const insert = left + selected + right;
      this.value = this.value.slice(0, start) + insert + this.value.slice(end);
      this.$nextTick(() => {
        ta.focus();
        ta.setSelectionRange(start + left.length, start + left.length + selected.length);
      });
    },

    prefix(p) {
      const ta = this.$refs.ta;
      const start = ta.selectionStart;
      const lineStart = this.value.lastIndexOf("\n", start - 1) + 1;
      this.value = this.value.slice(0, lineStart) + p + this.value.slice(lineStart);
      this.$nextTick(() => ta.focus());
    },

    codeBlock() {
      const ta = this.$refs.ta;
      const start = ta.selectionStart, end = ta.selectionEnd;
      const selected = this.value.slice(start, end) || "code here";
      const insert = `\n\`\`\`php\n${selected}\n\`\`\`\n`;
      this.value = this.value.slice(0, start) + insert + this.value.slice(end);
      this.$nextTick(() => ta.focus());
    },

    insertLink() {
      const ta = this.$refs.ta;
      const start = ta.selectionStart, end = ta.selectionEnd;
      const selected = this.value.slice(start, end) || "link text";
      const insert = `[${selected}](https://example.com)`;
      this.value = this.value.slice(0, start) + insert + this.value.slice(end);
      this.$nextTick(() => ta.focus());
    },
  }));

});


Alpine.start();