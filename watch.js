#!/usr/bin/env node

import { watch } from 'fs';
import { exec } from 'child_process';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const srcDir = resolve(__dirname, 'src');
const templatePartsDir = resolve(__dirname, 'template-parts');
const cssDir = resolve(__dirname, 'src/css');
const jsDir = resolve(__dirname, 'src/js');
const assetsDir = resolve(__dirname, 'assets');

console.log('🔍 Watching for changes in src/, template-parts/, src/css/, and src/js/ directories...');
console.log('📁 Source directory:', srcDir);
console.log('📁 Template parts directory:', templatePartsDir);
console.log('📁 CSS directory:', cssDir);
console.log('📁 JS directory:', jsDir);
console.log('📦 Output directory:', assetsDir);
console.log('⏹️  Press Ctrl+C to stop watching\n');

let isBuilding = false;

function build() {
  if (isBuilding) {
    console.log('⏳ Build already in progress, skipping...');
    return;
  }
  
  isBuilding = true;
  console.log('🔨 Building...');
  
  exec('vite build', { cwd: __dirname }, (error, stdout, stderr) => {
    isBuilding = false;
    
    if (error) {
      console.error('❌ Build failed:', error.message);
      return;
    }
    
    console.log('✅ Build completed successfully');
    console.log('⏰', new Date().toLocaleTimeString());
    console.log('---');
  });
}

// Initial build
build();

// Watch for changes in src directory
watch(srcDir, { recursive: true }, (eventType, filename) => {
  if (filename) {
    console.log(`📝 File changed in src/: ${filename}`);
    build();
  }
});

// Watch for changes in template-parts directory
watch(templatePartsDir, { recursive: true }, (eventType, filename) => {
  if (filename) {
    console.log(`📝 File changed in template-parts/: ${filename}`);
    build();
  }
});

// Watch for changes in css directory
watch(cssDir, { recursive: true }, (eventType, filename) => {
  if (filename) {
    console.log(`📝 File changed in css/: ${filename}`);
    build();
  }
});

// Watch for changes in js directory
watch(jsDir, { recursive: true }, (eventType, filename) => {
  if (filename) {
    console.log(`📝 File changed in js/: ${filename}`);
    build();
  }
});

console.log('🚀 Watch mode started. Make changes to files in src/, template-parts/, src/css/, or src/js/ to trigger rebuilds.'); 