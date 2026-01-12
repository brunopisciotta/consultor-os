module.exports = {
  content: ["./src/Views/**/*.php", "./public/assets/js/**/*.js"],
  theme: {
    extend: {
      colors: {
        gmr: {
          navy: '#1A2B42',  // Azul escuro profundo (baseado no logo)
          gold: '#D4AF37',  // Dourado do ícone
          gold_light: '#F3E5AB',
          gray: '#F5F7FA',  // Fundo leve para paineis
          text: '#333333'
        }
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Moderna e limpa para dashboard
        serif: ['Playfair Display', 'serif'], // Para títulos premium na LP
      }
    },
  },
  plugins: [],
}