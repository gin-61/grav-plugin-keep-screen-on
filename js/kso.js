document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector("#screen_wake_container");
  const wakeButton = document.querySelector("#wake_toggle_btn");

  // Get individual data attributes with fallbacks
  const hcode1 = container?.dataset.hcode1 || "🔛 Screen Wake Active";
  const hcode2 = container?.dataset.hcode2 || "🔲 Enable Screen Wake";
  const hcode3 = container?.dataset.hcode3 || "❌ Not Supported";

  // Wake Lock functionality
  let wakeLock = null;
  let isActive = false;

  // Check if required elements exist
  if (!container || !wakeButton) {
    console.error("Screen wake container or button not found");
    return;
  }

  const updateButtonState = () => {
    if (isActive) {
      wakeButton.innerHTML = hcode1;
      wakeButton.classList.remove("inactive");
      wakeButton.title = "Screen wake lock is active";
    } else {
      wakeButton.innerHTML = hcode2;
      wakeButton.classList.add("inactive");
      wakeButton.title = "Click to activate screen wake lock";
    }
  };

  const requestWakeLock = async () => {
    try {
      if (!("wakeLock" in navigator)) {
        throw new Error("Wake Lock API not supported in this browser");
      }

      wakeLock = await navigator.wakeLock.request("screen");
      isActive = true;
      updateButtonState();

      wakeLock.addEventListener("release", () => {
        console.log("Wake Lock was released by the system");
        isActive = false;
        updateButtonState();
      });

      // Handle visibility change
      const handleVisibilityChange = async () => {
        if (wakeLock !== null && document.visibilityState === "visible") {
          try {
            wakeLock = await navigator.wakeLock.request("screen");
            isActive = true;
            updateButtonState();
          } catch (err) {
            console.error("Error reacquiring wake lock:", err);
            isActive = false;
            updateButtonState();
          }
        }
      };

      document.addEventListener("visibilitychange", handleVisibilityChange);
    } catch (err) {
      console.error("Error requesting wake lock:", err);
      wakeButton.innerHTML = hcode3;
      wakeButton.disabled = true;
      wakeButton.title = "Wake Lock API not supported";
      isActive = false;
    }
  };

  const releaseWakeLock = () => {
    if (wakeLock) {
      wakeLock.release();
      wakeLock = null;
    }
    isActive = false;
    updateButtonState();
  };

  // Toggle functionality
  wakeButton.addEventListener("click", () => {
    if (isActive) {
      releaseWakeLock();
    } else {
      requestWakeLock();
    }
  });

  // Initial state
  updateButtonState();

  // Cleanup
  window.addEventListener("beforeunload", () => {
    if (wakeLock) {
      wakeLock.release();
    }
  });
});
