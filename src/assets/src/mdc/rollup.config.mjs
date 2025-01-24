import { nodeResolve } from '@rollup/plugin-node-resolve';

export default {
    input: '../assets/src/js/index.js',
    output: {
        file: '../assets/src/js/bundle.js',
        format: 'iife'
    },
    plugins: [
        nodeResolve(),
    ]
};