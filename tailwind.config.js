export default {
  theme: {
    extend: {
      keyframes: {
        bikeMove: {
          "0%": { transform: "translateX(-20vw) translateY(0)" },
          "25%": { transform: "translateX(25vw) translateY(-1px)" },
          "50%": { transform: "translateX(50vw) translateY(1px)" },
          "75%": { transform: "translateX(75vw) translateY(-1px)" },
          "100%": { transform: "translateX(120vw) translateY(0)" },
        },
      },
      animation: {
        bike: "bikeMove 7s linear infinite",
      },
    },
  },
};
