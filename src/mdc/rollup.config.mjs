import { nodeResolve } from '@rollup/plugin-node-resolve';

export default {
    input: '../assets/src/js/index.js',
    output: {
        file: '../assets/dist/js/bundle-1.js',
        format: 'iife'
    },
    plugins: [nodeResolve()]
};