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

function initCartDrawer() {
  const overlay = document.getElementById("nc-cart-drawer-overlay");
  const drawer = document.getElementById("nc-cart-drawer");
  const openButtons = document.querySelectorAll("[data-nc-cart-open]");
  const closeButtons = document.querySelectorAll("[data-nc-cart-close]");

  const openDrawer = () => {
    overlay?.classList.add("is-open");
    drawer?.classList.add("is-open");
    document.body.style.overflow = "hidden";
  };

  const closeDrawer = () => {
    overlay?.classList.remove("is-open");
    drawer?.classList.remove("is-open");
    document.body.style.overflow = "";
  };

  openButtons.forEach((btn) => btn.addEventListener("click", openDrawer));
  closeButtons.forEach((btn) => btn.addEventListener("click", closeDrawer));
  overlay?.addEventListener("click", closeDrawer);

  window.ncOpenCart = openDrawer;
  window.ncCloseCart = closeDrawer;
}

function initSearchModal() {
  const layer = document.getElementById("nc-search-layer");
  const openButtons = document.querySelectorAll("[data-nc-search-open]");
  const closeButtons = document.querySelectorAll("[data-nc-search-close]");
  const input = document.getElementById("nc-search-input");

  const openSearch = () => {
    layer?.classList.add("is-open");
    document.body.style.overflow = "hidden";
    setTimeout(() => input?.focus(), 100);
  };

  const closeSearch = () => {
    layer?.classList.remove("is-open");
    document.body.style.overflow = "";
  };

  openButtons.forEach((btn) => btn.addEventListener("click", openSearch));
  closeButtons.forEach((btn) => btn.addEventListener("click", closeSearch));

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && layer?.classList.contains("is-open")) {
      closeSearch();
    }
  });
}

function initMobileMenu() {
  const menuBtn = document.querySelector("[data-nc-menu-toggle]");
  const mobileNav = document.querySelector("[data-nc-mobile-nav]");

  menuBtn?.addEventListener("click", () => {
    mobileNav?.classList.toggle("hidden");
  });
}

function initQuickAdd() {
  const quickAddButtons = document.querySelectorAll("[data-nc-quick-add]");

  quickAddButtons.forEach((button) => {
    button.addEventListener("click", async (e) => {
      e.preventDefault();
      const productId = button.getAttribute("data-product-id");
      if (!productId) return;

      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

      try {
        const response = await fetch(`/checkout/cart/add/${productId}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token || "",
            "Accept": "application/json",
          },
          body: JSON.stringify({
            product_id: productId,
            quantity: 1,
          }),
        });

        const data = await response.json();

        if (response.ok) {
          showToast(data.message || "Product added to your bag.");
          updateCartBadges(data.data?.items_count || data.cart_count || "+1");
          if (window.ncOpenCart) {
            window.ncOpenCart();
          }
        } else {
          showToast(data.message || "Could not add to bag.");
        }
      } catch (err) {
        showToast("Added to bag!");
      }
    });
  });
}

function updateCartBadges(count) {
  const badges = document.querySelectorAll("[data-nc-cart-count]");
  badges.forEach((b) => {
    if (count !== undefined) {
      b.textContent = count;
    }
  });
}

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

document.addEventListener("DOMContentLoaded", () => {
  initScrollReveal();
  initCartDrawer();
  initSearchModal();
  initMobileMenu();
  initQuickAdd();
});
