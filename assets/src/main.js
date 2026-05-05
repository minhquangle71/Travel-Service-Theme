import "./style.css";

const bikeRoad = document.querySelector("[data-bike-road]");
const bike = bikeRoad?.querySelector("[data-bike]");
const stopZones = bikeRoad
  ? Array.from(bikeRoad.querySelectorAll("[data-bike-stop-zone]"))
  : [];

if (bikeRoad && bike && stopZones.length > 0) {
  let currentLeft = 0;

  const setBikeDirection = (targetLeft) => {
    const isMovingRight = Number.isFinite(currentLeft)
      ? targetLeft > currentLeft
      : true;

    bike.classList.toggle("is-facing-right", isMovingRight);
    bike.classList.toggle("is-facing-left", !isMovingRight);
  };

  const getTargetLeft = (stopZone) => {
    const roadRect = bikeRoad.getBoundingClientRect();
    const stopRect = stopZone.getBoundingClientRect();
    return Math.max(
      0,
      Math.min(
        stopRect.left -
          roadRect.left +
          stopRect.width / 2 -
          bike.offsetWidth / 2,
        roadRect.width - bike.offsetWidth,
      ),
    );
  };

  const setActiveStopZone = (activeIndex) => {
    stopZones.forEach((stopZone, index) => {
      const isActive = index === activeIndex;
      stopZone.classList.toggle("is-active", isActive);
      stopZone.setAttribute("aria-pressed", isActive ? "true" : "false");
    });
  };

  const moveBikeToStopZone = (stopZone, index) => {
    const targetLeft = getTargetLeft(stopZone);

    setBikeDirection(targetLeft);
    bike.classList.add("is-moving");
    bike.style.left = `${targetLeft}px`;
    bike.dataset.parkedIndex = `${index}`;
    setActiveStopZone(index);
    currentLeft = targetLeft;
  };

  const moveBikeToNextStopZone = () => {
    const parkedIndex = Number.parseInt(bike.dataset.parkedIndex ?? "-1", 10);
    const nextIndex =
      parkedIndex >= 0 ? (parkedIndex + 1) % stopZones.length : 0;
    moveBikeToStopZone(stopZones[nextIndex], nextIndex);
  };

  stopZones.forEach((stopZone, index) => {
    stopZone.setAttribute("aria-pressed", "false");
    stopZone.addEventListener("click", () => {
      moveBikeToStopZone(stopZone, index);
    });
  });

  currentLeft = Number.parseFloat(window.getComputedStyle(bike).left) || 0;

  bike.addEventListener("click", moveBikeToNextStopZone);
  bike.addEventListener("keydown", (event) => {
    if (event.key !== "Enter" && event.key !== " ") {
      return;
    }

    event.preventDefault();
    moveBikeToNextStopZone();
  });

  bike.addEventListener("transitionend", (event) => {
    if (event.propertyName === "left") {
      bike.classList.remove("is-moving");
    }
  });

  window.addEventListener("resize", () => {
    const parkedIndex = Number.parseInt(bike.dataset.parkedIndex ?? "-1", 10);
    if (parkedIndex >= 0) {
      bike.style.left = `${getTargetLeft(stopZones[parkedIndex])}px`;
    }
  });
}
