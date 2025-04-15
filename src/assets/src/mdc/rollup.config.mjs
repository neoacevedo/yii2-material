import resolve from '@rollup/plugin-node-resolve';
import { terser } from '@rollup/plugin-terser';
import summary from 'rollup-plugin-summary';

export default {
    input: '../assets/src/js/index.js',
    output: {
        file: '../assets/src/js/bundle.js',
        format: 'iife'
    },
    plugins: [
        resolve(),
        terser({
            ecma: 2021,
            module: true,
            warnings: true,
        }),
        summary(),
    ]
};