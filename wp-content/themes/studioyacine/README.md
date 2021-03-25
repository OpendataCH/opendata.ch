# Install:

This tutorial will guide you through the necessary steps to setup a dev environment for studioyacine Wordpress theme.

## 1. Install Node JS

### 1a. Node

[https://nodejs.org](https://nodejs.org)

Install latest version.

## 2. Install dependencies

### 2a. Node

    npm install

**Optional:** If you have NVM installed and wanna make sure you're using the correct Node version. Run the following command.

    nvm use

## 3. Run

To start a local server (to develop):

    npm run dev

if you want to run at a custom port:

    PORT=6789 npm run dev

## Common errors

Wrong Node version.

    micromatch/index.js:44 let isMatch = picomatch(String(patterns[i]), { ...options, onResult }, true);

**Solution:** Upgrade your Node version to atleast 10.16.
