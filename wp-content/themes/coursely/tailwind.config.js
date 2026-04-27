/** @type {string[]} */

const contentPaths = [
	'App/**/*.php',
	'assets/src/**/*.{js,jsx,ts,html}'
];

module.exports = {
  content: contentPaths,
  theme: {
    extend: {
		top:{
			'calc-50-24': 'calc(50% - 24px)',
		},
		keyframes: {
			appearFromCenter: {
				'0%': { opacity: '0', transform: 'scale(0.5)' },
				'100%': { opacity: '1', transform: 'scale(1)' },
			},
		},
		boxShadow:{
			'custom-shadow':'0px 2px 24px 0px #1B25591A'
		},
		padding: {
			'safe': 'env(safe-area-inset-bottom)'
		},
		animation: {
			appearFromCenter: 'appearFromCenter 0.8s ease-out forwards',
		},
		width: {
			'calc-100-320': 'calc(100% - 320px)',
			'calc-100-40': 'calc(100% - 40px)',
		},
		height:{
			'calc-100-100': 'calc(100vh - 100px)',
		},

		fontSize: {
			'xs': '0.75rem',// 12px
			'sm': '0.875rem',//14px
			'base': '1rem', //16px
			'lg': '1.125rem', // 18px
			'xl': '1.25rem', //~20px
			'2xl': '1.563rem',//~25px
			'3xl': '1.953rem',
			'4xl': '2.441rem',
			'5xl': '3.052rem',
		},
		screens: {
			'xsm': '320px',
			'xm' : '375px',
			'xmm' : '390px',
			'xml' : '430px',
			'xs': '480px',
			'smx': '600px',
			'sm': '640px',
			'md': '768px',
			'mdx': '991px',
			'lg': '1024px',
			'lgx': '1199px',
			'l': '1200px',
			'xl': '1280px',
			'1xl': '1366px',
			'2xl': '1440px',
			'3xl':'1600px',
			'4xl': '1920px'
		},
		colors: {
			'brand':{
				DEFAULT:'#1C55E0',
				'dark':'#111230',
				'gray':'#F4F4F5',
				'text':'#667085',
				'light-gray':'#0F051A80',


				'accent':'#E93C35',

				'error':'#ff0000'
			},
			'gray':'#DDE1E6',
			'half-white':'rgba(255,255,255,0.7)',
			'half-black':'rgba(43,48,52,0.7)',
			transparent:'transparent',
			current:'currentColor',
		},
	},
  },
  plugins: [
	  require('@tailwindcss/typography'),
	  require('tailwindcss-content-visibility'),
	  require('@tailwindcss/line-clamp'),
  ],
  corePlugins: {
	  tableLayout: true,
  },
}
