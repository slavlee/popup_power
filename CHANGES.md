### Version 1.3.4
- [BUGFIX] CGL: single_space_around_construct

### Version 1.3.3
- [BUGFIX] Hide Popup Inner Container, when Popup is not shown

### Version 1.3.2
- [BUGFIX] Close Button is optional
- [NOTICE] AutoClose on click outside only if not layout: confirm (NEW PRO FEATURE)
- [NOTICE] Save popup inside window.popupPower

### Version 1.3.1
- [BUGFIX] Backend module access comma separated value is not possbile anymore. Set to user

### Version 1.3.0
- [IMPORTANT] AssignVarsForDashboardEvent: Add Configuration in Constructor as required
- [FEATURE] Add Event to change Module Settings in DOM
- [FEATURE] Add Hooks for PopupPro JS Module: controlPopupAppearance, closePopup

### Version 1.2.3
- [NOTICE] Add german translation
- [NOTICE] Extend Free vs. Pro table
- [NOTICE] Add Buy Pro notice on Dashboard, if no popup-power-pro is installed

### Version 1.2.2
- [NOTICE] Changed Buy Pro Version URL

### Version 1.2.1
- [NOTICE] Add Buy Pro Version Section and Link

### Version 1.2.0
- [FEATURE] Increase configuration limit up to 999, when popup_power_pro is loaded
- [FEATURE] Add view folders in plugin typoscript
- [FEATURE] Add Event to add fluid variables for backend dashboard
- [FEATURE] If user change appearance behavoir from once back to always, then we delete the cookie

### Version 1.1.0
- [IMPORTANT] Introduce LicenseService to limit several functionalities for FREE version
- [FEATURE] In Free version you can only create 3 configurations
- [FEATURE] AutoClose Popup, if clicked outside
- [FEATURE] Add new appearance behaviour: always
- [FEATURE] Add new positions: center left, center, right, bottom left, bottom center and bottom right

### Version 1.0.3
- [BUGFIX] ClosestConfigurationService->get need to be able to return no configuration, if not found

### Version 1.0.2
- !!![IMPORTANT] Please clear injection cache, when upgrading from prio versions
- [BUGFIX] Each popup configuration uses now different cookies to make it possible to use multiple popups on multiple pages

### Version 1.0.1
- [BUGFIX] Improve appearance on small devices

### Version 1.0.0
- [IMPORTANT] First stable version
- [FEATURE] Base Appearance for Popup
- [FEATURE] Add delay in config
- [NOTICE] Add some css styling definition for inner container

### Version 0.0.5
- [FEATURE] Add JS Modul to control appearance of popup
- [FEATURE] Add basic styling for popup as modal

### Version 0.0.4
- [FEATURE] Add layout, position, behaviour_appearance field in configuration
- [FEATURE] Add new page type to create content for popups
- [FEATURE] Render popup content via lib.popup_power.renderPage Object
- [FEATURE] Set page id with Popup content

### Version 0.0.3
- [FEATURE] Create Frontend Plugin and add it to PAGE, when popup is enabled
- [BUGFIX] Renamed label in backend module for hidden field
- [WIP] Base Appearance for Popup
- [WIP] Set page id with Popup content

### Version 0.0.2
- [IMPORTANT] Add Backend Module to create and remove configuration
- [FEATURE] Configuration model to enable popup for pages

### Version 0.0.1
- [IMPORTANT] Kickstart extension
- [FEATURE] Setup GitHub workflow for CGL V12 and V13
