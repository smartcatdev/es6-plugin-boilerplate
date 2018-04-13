# Getting Started
- Edit the `build.entry` property in build.config.js following the format of: `{ filename: path }`

## Loading assets
- A `Manifest.json` is automatically generated by the build that contains a listing of the CSS and JS files generated by the build process
- Manifest is automatically read and cached on plugins_loaded

## Using Travis CI
- A base config has been provided 
- Create an API key at <a href="https://github.com/settings/tokens">https://github.com/settings/tokens</a>
- Add a hidden environment variable called `GITHUB_API_KEY` with your token
