/**
 * Scroll reveal observer.
 */
function initScrollReveal() {
  const elements = document.querySelectorAll(".reveal");
  if (!elements.length) return;

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12 }
  );

  elements.forEach((el) => observer.observe(el));
}

/**
 * Slide-out cart drawer.
 */
function initCartDrawer() {
  const getDrawer = () => document.getElementById("nc-cart-drawer");
  const getOverlay = () => document.getElementById("nc-cart-drawer-overlay");

  const openDrawer = () => {
    getOverlay()?.classList.add("is-open");
    getDrawer()?.classList.add("is-open");
    document.body.style.overflow = "hidden";
  };

  const closeDrawer = () => {
    getOverlay()?.classList.remove("is-open");
    getDrawer()?.classList.remove("is-open");
    document.body.style.overflow = "";
  };

  document.addEventListener("click", (e) => {
    if (e.target.closest("[data-nc-cart-open]")) {
      e.preventDefault();
      openDrawer();
    } else if (e.target.closest("[data-nc-cart-close]") || e.target === getOverlay()) {
      e.preventDefault();
      closeDrawer();
    }
  });

  window.ncOpenCart = openDrawer;
  window.ncCloseCart = closeDrawer;
}

/**
 * Search overlay modal.
 */
function initSearchModal() {
  const getLayer = () => document.getElementById("nc-search-layer");
  const getInput = () => document.getElementById("nc-search-input");

  const openSearch = () => {
    const layer = getLayer();
    layer?.classList.add("is-open");
    document.body.style.overflow = "hidden";
    setTimeout(() => getInput()?.focus(), 100);
  };

  const closeSearch = () => {
    const layer = getLayer();
    layer?.classList.remove("is-open");
    document.body.style.overflow = "";
  };

  document.addEventListener("click", (e) => {
    if (e.target.closest("[data-nc-search-open]")) {
      e.preventDefault();
      openSearch();
    } else if (e.target.closest("[data-nc-search-close]")) {
      e.preventDefault();
      closeSearch();
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && getLayer()?.classList.contains("is-open")) {
      closeSearch();
    }
  });
}

/**
 * Mobile navigation menu.
 */
function initMobileMenu() {
  document.addEventListener("click", (e) => {
    if (e.target.closest("[data-nc-menu-toggle]")) {
      const mobileNav = document.querySelector("[data-nc-mobile-nav]");
      mobileNav?.classList.toggle("hidden");
    }
  });
}

/**
 * Announcement ticker.
 */
function initAnnouncementTicker() {
  const ticker = document.querySelector("[data-nc-announcement-ticker]");
  if (!ticker) return;

  const slides = ticker.querySelectorAll("[data-nc-announcement-slide]");
  if (slides.length <= 1) return;

  const speed = parseInt(ticker.getAttribute("data-speed") || "4000", 10);
  let currentIndex = 0;

  setInterval(() => {
    const currentSlide = slides[currentIndex];
    currentSlide.classList.remove("opacity-100", "translate-y-0", "relative");
    currentSlide.classList.add("opacity-0", "-translate-y-4", "absolute", "pointer-events-none");

    currentIndex = (currentIndex + 1) % slides.length;

    const nextSlide = slides[currentIndex];
    nextSlide.classList.remove("opacity-0", "-translate-y-4", "absolute", "pointer-events-none");
    nextSlide.classList.add("opacity-100", "translate-y-0", "relative");
  }, speed);
}

/**
 * Products slider.
 */
function initProductsSlider() {
  const getScrollStep = (container) => {
    const firstCard = container.querySelector("article");
    return firstCard ? firstCard.offsetWidth + 24 : 320;
  };

  document.addEventListener("click", (e) => {
    const nextBtn = e.target.closest("[data-nc-slider-next]");
    const prevBtn = e.target.closest("[data-nc-slider-prev]");

    if (!nextBtn && !prevBtn) return;

    const parentSection = (nextBtn || prevBtn).closest("section");
    const container = parentSection?.querySelector("[data-nc-slider-container]");
    if (!container) return;

    const step = getScrollStep(container);
    const isRtl = document.documentElement.dir === "rtl" || document.body.dir === "rtl";

    if (nextBtn) {
      container.scrollBy({
        left: isRtl ? -step : step,
        behavior: "smooth",
      });
    } else if (prevBtn) {
      container.scrollBy({
        left: isRtl ? step : -step,
        behavior: "smooth",
      });
    }
  });
}

/**
 * Toast notification presenter.
 */
function showToast(message) {
  let container = document.getElementById("nc-toast-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "nc-toast-container";
    document.body.appendChild(container);
  }

  const toast = document.createElement("div");
  toast.className = "nc-toast";
  toast.textContent = message;
  container.appendChild(toast);

  requestAnimationFrame(() => {
    toast.classList.add("is-active");
  });

  setTimeout(() => {
    toast.classList.remove("is-active");
    setTimeout(() => toast.remove(), 400);
  }, 3500);
}

window.showToast = showToast;

/**
 * Update cart count indicators across the DOM.
 */
function updateCartBadges(count) {
  const badges = document.querySelectorAll("[data-nc-cart-count]");
  const cleanCount = Math.floor(parseFloat(count) || 0);
  badges.forEach((b) => {
    b.textContent = cleanCount;
    if (cleanCount > 0) {
      b.classList.remove("scale-0", "opacity-0");
      b.classList.add("scale-100", "opacity-100");
    } else {
      b.classList.remove("scale-100", "opacity-100");
      b.classList.add("scale-0", "opacity-0");
    }
  });
}

/**
 * Update cart drawer contents dynamically.
 */
function updateCartDrawer(cartData) {
  if (!cartData) return;

  const emptyState = document.getElementById("nc-cart-empty-state");
  const itemsList = document.getElementById("nc-cart-items-list");
  const footer = document.getElementById("nc-cart-drawer-footer");
  const subtotalEl = document.getElementById("nc-cart-drawer-subtotal");

  const items = cartData.items || [];
  const count = Math.floor(parseFloat(cartData.items_qty || cartData.items_count || items.length) || 0);

  updateCartBadges(count);

  if (subtotalEl && (cartData.formatted_sub_total || cartData.formatted_grand_total)) {
    subtotalEl.textContent = cartData.formatted_sub_total || cartData.formatted_grand_total;
  }

  if (!items.length) {
    emptyState?.classList.remove("hidden");
    itemsList?.classList.add("hidden");
    footer?.classList.add("hidden");
    return;
  }

  emptyState?.classList.add("hidden");
  itemsList?.classList.remove("hidden");
  footer?.classList.remove("hidden");

  let html = "";
  items.forEach((item) => {
    const imageUrl = item.base_image?.small_image_url || item.base_image?.medium_image_url || "/themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg";
    const price = item.formatted_total || item.formatted_price || "";
    html += `
      <div class="flex gap-4 pb-6 border-b border-[#2e2224]/10">
        <img src="${imageUrl}" alt="${item.name}" class="w-20 h-20 object-cover border border-[#2e2224]" />
        <div class="flex-1 flex flex-col justify-between">
          <div>
            <h3 class="font-serif font-bold text-sm leading-snug">${item.name}</h3>
            <p class="font-mono text-xs text-[#2e2224]/60 mt-1">QTY: ${item.quantity}</p>
          </div>
          <div class="font-mono text-sm font-bold text-[var(--magenta)]">${price}</div>
        </div>
      </div>
    `;
  });

  if (itemsList) {
    itemsList.innerHTML = html;
  }
}

/**
 * Product detail page quantity changer.
 */
function initProductQuantity() {
  const qtyInput = document.getElementById("nc-product-qty");
  const decBtn = document.getElementById("nc-qty-decrement");
  const incBtn = document.getElementById("nc-qty-increment");

  if (!qtyInput) return;

  decBtn?.addEventListener("click", () => {
    const current = parseInt(qtyInput.value, 10) || 1;
    if (current > 1) {
      qtyInput.value = current - 1;
    }
  });

  incBtn?.addEventListener("click", () => {
    const current = parseInt(qtyInput.value, 10) || 1;
    qtyInput.value = current + 1;
  });
}

/**
 * Configurable product attribute options selection.
 */
function initConfigurableProduct() {
  const configScript = document.getElementById("nc-configurable-config");
  if (!configScript) return;

  let config;
  try {
    config = JSON.parse(configScript.textContent);
  } catch (err) {
    return;
  }

  if (!config || !config.attributes) return;

  const selectedOptions = {};
  const selectedVariantInput = document.getElementById("nc-selected-configurable-option");
  const priceBox = document.getElementById("nc-product-price-box");
  const mainImage = document.getElementById("nc-main-product-image");
  const swatchButtons = document.querySelectorAll(".nc-swatch-option");

  swatchButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const attrId = btn.getAttribute("data-attr-id");
      const optionId = btn.getAttribute("data-option-id");
      const optionLabel = btn.getAttribute("data-option-label");
      const attrContainer = btn.closest(".nc-config-attribute");

      if (!attrId || !optionId) return;

      selectedOptions[attrId] = parseInt(optionId, 10);

      const superInput = document.getElementById(`nc-super-attr-${attrId}`);
      if (superInput) {
        superInput.value = optionId;
      }

      if (attrContainer) {
        const labelDisplay = attrContainer.querySelector(".nc-selected-label");
        if (labelDisplay && optionLabel) {
          labelDisplay.textContent = optionLabel;
        }

        const siblingButtons = attrContainer.querySelectorAll(".nc-swatch-option");
        siblingButtons.forEach((sBtn) => {
          sBtn.classList.remove("nc-swatch-selected", "nc-swatch-color-selected");
        });

        if (btn.classList.contains("nc-swatch-color")) {
          btn.classList.add("nc-swatch-color-selected");
        } else {
          btn.classList.add("nc-swatch-selected");
        }
      }

      const allSelected = config.attributes.every((attr) => selectedOptions[attr.id]);
      if (!allSelected) {
        if (selectedVariantInput) selectedVariantInput.value = "";
        return;
      }

      const variantId = Object.keys(config.index).find((vId) => {
        return config.attributes.every((attr) => config.index[vId][attr.id] == selectedOptions[attr.id]);
      });

      if (variantId) {
        if (selectedVariantInput) {
          selectedVariantInput.value = variantId;
        }

        const variantPrice = config.variant_prices?.[variantId];
        if (variantPrice && priceBox) {
          const formatted = variantPrice.final?.formatted_price || variantPrice.regular?.formatted_price;
          if (formatted) {
            priceBox.innerHTML = `<span>${formatted}</span>`;
          }
        }

        const variantImages = config.variant_images?.[variantId];
        if (variantImages && variantImages.length && mainImage) {
          const firstImg = variantImages[0];
          const newSrc = firstImg.large_image_url || firstImg.medium_image_url || firstImg.original_image_url;
          const newZoom = firstImg.original_image_url || newSrc;
          mainImage.src = newSrc;
          mainImage.setAttribute("data-zoom-src", newZoom);

          if (window.ncUpdateGallery) {
            window.ncUpdateGallery(variantImages);
          }
        }
      }
    });
  });
}

/**
 * Product media gallery, hover zoom, and lightbox modal zoomer.
 */
function initProductGalleryAndZoom() {
  const stage = document.getElementById("nc-product-stage-container");
  const mainImage = document.getElementById("nc-main-product-image");
  const openZoomBtn = document.getElementById("nc-open-zoom-btn");
  const modal = document.getElementById("nc-zoom-modal");
  const modalImg = document.getElementById("nc-zoom-modal-img");
  const closeBtn = document.getElementById("nc-zoom-close-btn");
  const inBtn = document.getElementById("nc-zoom-in-btn");
  const outBtn = document.getElementById("nc-zoom-out-btn");
  const resetBtn = document.getElementById("nc-zoom-reset-btn");
  const prevBtn = document.getElementById("nc-zoom-prev-btn");
  const nextBtn = document.getElementById("nc-zoom-next-btn");
  const counterEl = document.getElementById("nc-zoom-counter");
  const modalThumbs = document.getElementById("nc-zoom-modal-thumbs");
  const thumbsContainer = document.getElementById("nc-gallery-thumbnails");

  if (!stage || !mainImage) return;

  let currentGallery = [];
  const galleryScript = document.getElementById("nc-gallery-data");
  if (galleryScript) {
    try {
      currentGallery = JSON.parse(galleryScript.textContent) || [];
    } catch (e) {
      currentGallery = [];
    }
  }

  let activeIndex = 0;
  let modalScale = 1;

  const selectThumbnail = (index) => {
    activeIndex = index;
    const thumbButtons = thumbsContainer?.querySelectorAll(".nc-thumb-btn") || [];
    thumbButtons.forEach((btn, idx) => {
      if (idx === index) {
        btn.classList.add("nc-thumb-active");
      } else {
        btn.classList.remove("nc-thumb-active");
      }
    });

    const activeItem = currentGallery[index];
    if (activeItem) {
      const largeUrl = activeItem.large_image_url || activeItem.original_image_url || activeItem.medium_image_url;
      const zoomUrl = activeItem.original_image_url || largeUrl;
      mainImage.src = largeUrl;
      mainImage.setAttribute("data-zoom-src", zoomUrl);
      if (modalImg) {
        modalImg.src = zoomUrl;
      }
    }
    updateModalCounter();
  };

  const bindThumbnails = () => {
    const thumbButtons = thumbsContainer?.querySelectorAll(".nc-thumb-btn") || [];
    thumbButtons.forEach((btn, idx) => {
      btn.addEventListener("click", () => selectThumbnail(idx));
    });
  };

  bindThumbnails();

  window.ncUpdateGallery = (newImages) => {
    currentGallery = newImages || [];
    activeIndex = 0;

    if (thumbsContainer && currentGallery.length > 1) {
      let html = "";
      currentGallery.forEach((im, idx) => {
        const thumbUrl = im.small_image_url || im.medium_image_url || im.large_image_url;
        const largeUrl = im.large_image_url || im.original_image_url;
        const zoomUrl = im.original_image_url || largeUrl;
        const activeClass = idx === 0 ? "nc-thumb-active" : "border-[#2e2224]/20";
        html += `
          <button
            type="button"
            data-image-index="${idx}"
            data-large-url="${largeUrl}"
            data-zoom-url="${zoomUrl}"
            class="nc-thumb-btn aspect-square bg-white border ${activeClass} hover:border-[var(--primary,#bd1765)] overflow-hidden p-1.5 transition-all cursor-pointer flex items-center justify-center"
          >
            <img src="${thumbUrl}" alt="Product" class="w-full h-full object-contain pointer-events-none" />
          </button>
        `;
      });
      thumbsContainer.innerHTML = html;
      bindThumbnails();
    }
    renderModalThumbs();
  };

  stage.addEventListener("mousemove", (e) => {
    const rect = stage.getBoundingClientRect();
    const x = Math.max(0, Math.min(100, ((e.clientX - rect.left) / rect.width) * 100));
    const y = Math.max(0, Math.min(100, ((e.clientY - rect.top) / rect.height) * 100));
    mainImage.style.transformOrigin = `${x}% ${y}%`;
    mainImage.style.transform = "scale(2.2)";
  });

  stage.addEventListener("mouseleave", () => {
    mainImage.style.transformOrigin = "center center";
    mainImage.style.transform = "scale(1)";
  });

  const updateModalCounter = () => {
    if (counterEl) {
      const total = currentGallery.length || 1;
      counterEl.textContent = `[ ${activeIndex + 1} / ${total} ]`;
    }
    const modalThumbBtns = modalThumbs?.querySelectorAll("button") || [];
    modalThumbBtns.forEach((b, idx) => {
      if (idx === activeIndex) {
        b.classList.add("border-[#bd1765]", "ring-2", "ring-[#bd1765]");
        b.classList.remove("opacity-50");
      } else {
        b.classList.remove("border-[#bd1765]", "ring-2", "ring-[#bd1765]");
        b.classList.add("opacity-50");
      }
    });
  };

  const renderModalThumbs = () => {
    if (!modalThumbs) return;
    if (currentGallery.length <= 1) {
      modalThumbs.innerHTML = "";
      return;
    }

    let html = "";
    currentGallery.forEach((im, idx) => {
      const thumbUrl = im.small_image_url || im.medium_image_url || im.large_image_url;
      const isSelected = idx === activeIndex;
      html += `
        <button
          type="button"
          data-modal-thumb="${idx}"
          class="w-12 h-12 border bg-white rounded overflow-hidden p-1 transition-all cursor-pointer ${isSelected ? "border-[#bd1765] ring-2 ring-[#bd1765]" : "border-white/30 opacity-50 hover:opacity-100"}"
        >
          <img src="${thumbUrl}" alt="Thumbnail" class="w-full h-full object-contain pointer-events-none" />
        </button>
      `;
    });
    modalThumbs.innerHTML = html;

    modalThumbs.querySelectorAll("[data-modal-thumb]").forEach((btn, idx) => {
      btn.addEventListener("click", () => selectThumbnail(idx));
    });
  };

  const applyModalZoom = (scale) => {
    modalScale = Math.max(1, Math.min(4, scale));
    if (modalImg) {
      modalImg.style.transform = `scale(${modalScale})`;
    }
  };

  const openModal = () => {
    if (!modal) return;
    modalScale = 1;
    applyModalZoom(1);
    const zoomSrc = mainImage.getAttribute("data-zoom-src") || mainImage.src;
    if (modalImg) {
      modalImg.src = zoomSrc;
    }
    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
    renderModalThumbs();
    updateModalCounter();
  };

  const closeModal = () => {
    if (!modal) return;
    modal.classList.add("hidden");
    document.body.style.overflow = "";
    modalScale = 1;
    applyModalZoom(1);
  };

  stage.addEventListener("click", (e) => {
    if (e.target.closest("#nc-open-zoom-btn")) return;
    openModal();
  });

  openZoomBtn?.addEventListener("click", openModal);
  closeBtn?.addEventListener("click", closeModal);

  inBtn?.addEventListener("click", () => applyModalZoom(modalScale + 0.5));
  outBtn?.addEventListener("click", () => applyModalZoom(modalScale - 0.5));
  resetBtn?.addEventListener("click", () => applyModalZoom(1));

  prevBtn?.addEventListener("click", () => {
    const total = currentGallery.length || 1;
    const newIdx = (activeIndex - 1 + total) % total;
    selectThumbnail(newIdx);
  });

  nextBtn?.addEventListener("click", () => {
    const total = currentGallery.length || 1;
    const newIdx = (activeIndex + 1) % total;
    selectThumbnail(newIdx);
  });

  modalImg?.addEventListener("click", () => {
    applyModalZoom(modalScale > 1.2 ? 1 : 2.5);
  });

  modal?.addEventListener("wheel", (e) => {
    e.preventDefault();
    if (e.deltaY < 0) {
      applyModalZoom(modalScale + 0.25);
    } else {
      applyModalZoom(modalScale - 0.25);
    }
  }, { passive: false });

  document.addEventListener("keydown", (e) => {
    if (modal?.classList.contains("hidden")) return;

    if (e.key === "Escape") {
      closeModal();
    } else if (e.key === "ArrowLeft") {
      const total = currentGallery.length || 1;
      const isRtl = document.documentElement.dir === "rtl" || document.body.dir === "rtl";
      selectThumbnail(isRtl ? (activeIndex + 1) % total : (activeIndex - 1 + total) % total);
    } else if (e.key === "ArrowRight") {
      const total = currentGallery.length || 1;
      const isRtl = document.documentElement.dir === "rtl" || document.body.dir === "rtl";
      selectThumbnail(isRtl ? (activeIndex - 1 + total) % total : (activeIndex + 1) % total);
    } else if (e.key === "+" || e.key === "=") {
      applyModalZoom(modalScale + 0.5);
    } else if (e.key === "-") {
      applyModalZoom(modalScale - 0.5);
    }
  });
}

/**
 * Quick add to bag button handler.
 */
function initQuickAdd() {
  const productForm = document.getElementById("nc-product-form");
  const quickAddButtons = document.querySelectorAll("[data-nc-quick-add]");

  if (productForm) {
    productForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const selectedVariantInput = document.getElementById("nc-selected-configurable-option");
      const configContainer = document.getElementById("nc-configurable-options");

      if (configContainer && selectedVariantInput && !selectedVariantInput.value) {
        showToast(window.ncTranslations?.select_options || "Please select the required options");
        configContainer.scrollIntoView({ behavior: "smooth", block: "center" });
        return;
      }

      const submitBtn = document.getElementById("nc-add-to-cart-btn");
      const originalText = submitBtn?.textContent;
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add("opacity-70");
      }

      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");
      const formData = new FormData(productForm);

      try {
        const response = await fetch("/api/checkout/cart", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": token || "",
            "Accept": "application/json",
          },
          body: formData,
        });

        const data = await response.json();

        if (response.ok) {
          showToast(data.message || window.ncTranslations?.added_to_bag || "Product added to your bag.");
          updateCartDrawer(data.data);
          if (window.ncOpenCart) {
            window.ncOpenCart();
          }
        } else if (data.redirect_uri) {
          window.location.href = data.redirect_uri;
        } else {
          showToast(data.message || window.ncTranslations?.error_add_to_bag || "Could not add to bag.");
        }
      } catch (err) {
        showToast(window.ncTranslations?.added_to_bag || "Added to bag!");
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.classList.remove("opacity-70");
          if (originalText) submitBtn.textContent = originalText;
        }
      }
    });
  }

  document.addEventListener("click", async (e) => {
    const button = e.target.closest("[data-nc-quick-add]");
    if (!button) return;

    e.preventDefault();

    if (button.closest("#nc-product-form")) return;

    const productId = button.getAttribute("data-product-id");
    const productType = button.getAttribute("data-product-type");
    const productUrl = button.getAttribute("data-product-url");

    if (!productId) return;

    if (productType === "configurable" && productUrl && productUrl !== "#") {
      window.location.href = productUrl;
      return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

    try {
      const response = await fetch("/api/checkout/cart", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token || "",
          "Accept": "application/json",
        },
        body: JSON.stringify({
          product_id: parseInt(productId, 10),
          quantity: 1,
        }),
      });

      const data = await response.json();

      if (response.ok) {
        showToast(data.message || window.ncTranslations?.added_to_bag || "Product added to your bag.");
        updateCartDrawer(data.data);
        if (window.ncOpenCart) {
          window.ncOpenCart();
        }
      } else if (data.redirect_uri) {
        window.location.href = data.redirect_uri;
      } else {
        showToast(data.message || window.ncTranslations?.error_add_to_bag || "Could not add to bag.");
      }
    } catch (err) {
      showToast(window.ncTranslations?.added_to_bag || "Added to bag!");
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initScrollReveal();
  initCartDrawer();
  initSearchModal();
  initMobileMenu();
  initAnnouncementTicker();
  initProductsSlider();
  initProductQuantity();
  initConfigurableProduct();
  initProductGalleryAndZoom();
  initQuickAdd();
});

