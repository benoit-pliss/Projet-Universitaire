tailwind.config = {
  theme: {
    extend: {
      animation: {
        wiggle: "wiggle 10s ease-in-out infinite",
      },
      keyframes: {
        wiggle: {
          "30%": { transform: "translateX(100%)" },
          "70%": { transform: "translateX(-100%)" },
        },
      },
    },
    screens: {
      'tablet': '640px',
      // => @media (min-width: 640px) { ... }

      'laptop': '1024px',
      // => @media (min-width: 1024px) { ... }

      'desktop': '1280px',
      // => @media (min-width: 1280px) { ... }
    },
  },
};
