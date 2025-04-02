const fs = require('fs');
const path = require('path');

const blockName = process.argv[2];

if (!blockName) {
	console.error('⛔ Error name block: node create-block.js my-block');
	process.exit(1);
}

const blockSlug = blockName.toLowerCase().replace(/\s+/g, '-');
const capitalized = blockSlug.replace(/(^\w|-\w)/g, m => m.replace('-', '').toUpperCase());

const blockDir = path.join(__dirname, 'blocks', blockSlug);

if (fs.existsSync(blockDir)) {
	console.error(`⛔ Block "${blockSlug}" already exists`);
	process.exit(1);
}

fs.mkdirSync(blockDir, { recursive: true });

// block.json
const blockJson = {
	"name": `acf/${blockSlug}`,
	"title": capitalized,
	"description": capitalized,
	"category": "layout",
	"icon": "cover-image",
	"keywords": [capitalized, "banner", "acf"],
	"enqueueStyle": "file:./style.css",
	"enqueueEditorStyle": "file:./editor.css",
	"supports": {
		"align": true,
		"anchor": true
	},
	"acf": {
		"mode": "edit",
		"renderTemplate": "render.php"
	}
};

fs.writeFileSync(
	path.join(blockDir, 'block.json'),
	JSON.stringify(blockJson, null, 2)
);

// render.php
fs.writeFileSync(path.join(blockDir, 'render.php'), `<?php
/**
 * Render template for ${capitalized}
 */
?>

`);

// style.scss
fs.writeFileSync(path.join(blockDir, 'style.scss'), `@use '../../assets/scss/variables' as *;
@use '../../assets/scss/mixins' as *;

`);

fs.writeFileSync(path.join(blockDir, 'editor.css'), '');

fs.writeFileSync(path.join(blockDir, 'script.js'), `// JS for ${capitalized} block
`);

console.log(`✅ Block "${blockSlug}" created in /blocks/${blockSlug}`);