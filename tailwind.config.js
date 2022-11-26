const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
		"./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
			backgroundImage: {
			'qq-pattern': "url('/images/qq.png')",
			'gafa-pattern': "url('/images/qq.svg')",
			},
			width: {
			'128': '32rem',
			},
			spacing: {
			'100': '28rem',
			'128': '32rem',
			}
        },
		fontSize: {
			'2xs': '.5rem',
			'xs': '.75rem',
			'sm': '.875rem',
			'tiny': '.875rem',
			'base': '1rem',
			'lg': '1.125rem',
			'xl': '1.25rem',
			'2xl': '1.5rem',
			'3xl': '1.875rem',
			'4xl': '2.25rem',
			'5xl': '3rem',
			'6xl': '4rem',
			'7xl': '5rem',
			}
    },

    plugins: [	require('@tailwindcss/forms'), 
				require('@tailwindcss/typography'),
	],
};
