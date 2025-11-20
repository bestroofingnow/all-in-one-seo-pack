# Plugin Independence Checklist

## Changes Made to Remove AIOSEO Licensing

### ✅ Frontend (JavaScript/Vue)
- [x] `src/vue/stores/LicenseStore.js` - Always returns licensed
- [x] `src/vue/utils/license.js` - All feature checks return true
- [x] `src/vue/stores/ConnectStore.js` - Disabled Connect API calls
- [x] `src/vue/standalone/setup-wizard/router/paths.js` - Removed license-key route
- [x] `src/vue/standalone/setup-wizard/views/SmartRecommendations.vue` - Disabled purchase redirect

### ✅ Backend (PHP)
- [x] `app/AIOSEO.php` - Set $pro = true, $versionPath = 'Lite'
- [x] `app/AIOSEO.php` - loadVersion() always uses Lite structure
- [x] `app/AIOSEO.php` - preLoad() uses only Lite/Common classes
- [x] `app/AIOSEO.php` - load() uses only Lite/Common classes (NO Pro classes)
- [x] `app/Lite/Admin/Admin.php` - Disabled Connect class
- [x] `app/Lite/Admin/Admin.php` - Removed upgrade menus
- [x] `app/Common/Api/Api.php` - Disabled connect/license API routes

### ✅ Branding
- [x] `all_in_one_seo_pack.php` - Changed to "SEO AI Pro - Independent Edition"
- [x] `all_in_one_seo_pack.php` - Version 1.0.0
- [x] `README.md` - Updated with independence messaging

## Critical Code Paths

### Plugin Initialization Order:
1. `all_in_one_seo_pack.php` - Main plugin file
2. `app/init/init.php` - Defines aioseoMaybePluginIsDisabled()
3. `app/init/notices.php` - PHP version checks
4. `app/init/activation.php` - Activation hooks
5. `app/AIOSEO.php` - Main plugin class
   - `__construct()` - Sets up singleton
   - `init()` - Calls constants(), includes(), preLoad(), load()
   - `constants()` - Defines plugin constants
   - `includes()` - Loads vendor autoloader, calls loadVersion()
   - `loadVersion()` - Sets $this->pro = true, $this->versionPath = 'Lite'
   - `preLoad()` - Instantiates core, helpers (Lite), internalOptions (Lite)
   - `load()` - Instantiates ALL plugin classes (ALL use Lite/Common, NONE use Pro)

### Classes That MUST Be Lite/Common (Not Pro):
- helpers: Lite\Utils\Helpers ✓
- internalOptions: Lite\Options\InternalOptions ✓
- options: Lite\Options\Options ✓
- admin: Lite\Admin\Admin ✓
- api: Lite\Api\Api ✓
- postSettings: Lite\Admin\PostSettings ✓
- All others: Common\* ✓

### Classes Set to NULL (Disabled):
- $this->license = null (no licensing)
- $this->networkLicense = null (no licensing)
- $this->autoUpdates = null (independent)
- $this->ai = null (use aiManager instead)
- $this->term = null (Pro-only feature)

## Verification Commands

```bash
# Check for any remaining Pro class references
grep -r "new Pro\\\\" app/ --include="*.php" | grep -v ".backup"

# Check AIOSEO.php for Pro class loading
grep "Pro\\\\" app/AIOSEO.php

# Verify key class files exist
ls -la app/Lite/Admin/Admin.php
ls -la app/Lite/Options/Options.php
ls -la app/Common/Ai/AiManager.php

# Check PHP syntax
php -l app/AIOSEO.php
php -l app/Lite/Admin/Admin.php
php -l app/Common/Ai/AiManager.php
```

## If Fatal Error Persists

The error is likely one of:

1. **Autoloader issue** - Check vendor/autoload.php exists
2. **Missing class file** - One of the Common or Lite classes doesn't exist
3. **WordPress function called too early** - Some code calling WP functions before WP is loaded
4. **Syntax error** - Run `php -l` on all modified files

Check WordPress debug.log for exact error message with file and line number.
