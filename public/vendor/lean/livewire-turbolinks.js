/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/alpine-turbo-drive-adapter/dist/alpine-turbo-drive-adapter.esm.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/alpine-turbo-drive-adapter/dist/alpine-turbo-drive-adapter.esm.js ***!
  \****************************************************************************************/
/***/ (() => {

function isValidVersion(required, current) {
  const requiredArray = required.split('.');
  const currentArray = current.split('.');

  for (let i = 0; i < requiredArray.length; i++) {
    if (!currentArray[i] || currentArray[i] < requiredArray[i]) {
      return false;
    }
  }

  return true;
}
function beforeDomReady(callback) {
  if (document.readyState === 'loading') {
    document.addEventListener('readystatechange', () => {
      if (document.readyState === 'interactive') {
        callback();
      }
    });
  } else {
    callback();
  }
}

class Bridge {
  init() {
    // Tag all cloaked elements on first page load.
    document.body.querySelectorAll('[x-cloak]').forEach(el => {
      el.setAttribute('data-alpine-was-cloaked', el.getAttribute('x-cloak') ?? '');
    });
    this.configureEventHandlers();
  }

  setMutationObserverState(state) {
    if (!window.Alpine.version || !isValidVersion('2.4.0', window.Alpine.version)) {
      throw new Error('Invalid Alpine version. Please use Alpine 2.4.0 or above');
    }

    window.Alpine.pauseMutationObserver = state;
  }

  configureEventHandlers() {
    // Once Turbolinks finished is magic, we initialise Alpine on the new page
    // and resume the observer
    const initCallback = () => {
      window.Alpine.discoverUninitializedComponents(el => {
        window.Alpine.initializeComponent(el);
      });
      requestAnimationFrame(() => {
        this.setMutationObserverState(false);
      });
    }; // Before swapping the body, clean up any element with x-turbolinks-cached
    // which do not have any Alpine properties.
    // Note, at this point all html fragments marked as data-turbolinks-permanent
    // are already copied over from the previous page so they retain their listener
    // and custom properties and we don't want to reset them.


    const beforeRenderCallback = event => {
      const newBody = event.data ? event.data.newBody : event.detail.newBody;
      newBody.querySelectorAll('[data-alpine-generated-me],[x-cloak]').forEach(el => {
        if (el.hasAttribute('x-cloak')) {
          // When we get a new document body tag any cloaked elements so we can cloak
          // them again before caching.
          el.setAttribute('data-alpine-was-cloaked', el.getAttribute('x-cloak') ?? '');
        }

        if (el.hasAttribute('data-alpine-generated-me')) {
          el.removeAttribute('data-alpine-generated-me');

          if (typeof el.__x_for_key === 'undefined' && typeof el.__x_inserted_me === 'undefined') {
            el.remove();
          }
        }
      });
    }; // Pause the the mutation observer to avoid data races, it will be resumed by the turbolinks:load event.
    // We mark as `data-alpine-generated-m` all elements that are crated by an Alpine templating directives.
    // The reason is that turbolinks caches pages using cloneNode which removes listeners and custom properties
    // So we need to propagate this infomation using a HTML attribute. I know, not ideal but I could not think
    // of a better option.
    // Note, we can't remove any Alpine generated element as yet because if they live inside an element
    // marked as data-turbolinks-permanent they need to be copied into the next page.
    // The coping process happens somewhere between before-cache and before-render.


    const beforeCacheCallback = () => {
      this.setMutationObserverState(true);
      document.body.querySelectorAll('[x-for],[x-if],[data-alpine-was-cloaked]').forEach(el => {
        // Cloak any elements again that were tagged when the page was loaded
        if (el.hasAttribute('data-alpine-was-cloaked')) {
          el.setAttribute('x-cloak', el.getAttribute('data-alpine-was-cloaked') ?? '');
          el.removeAttribute('data-alpine-was-cloaked');
        }

        if (el.hasAttribute('x-for')) {
          let nextEl = el.nextElementSibling;

          while (nextEl && typeof nextEl.__x_for_key !== 'undefined') {
            const currEl = nextEl;
            nextEl = nextEl.nextElementSibling;
            currEl.setAttribute('data-alpine-generated-me', true);
          }
        } else if (el.hasAttribute('x-if')) {
          const ifEl = el.nextElementSibling;

          if (ifEl && typeof ifEl.__x_inserted_me !== 'undefined') {
            ifEl.setAttribute('data-alpine-generated-me', true);
          }
        }
      });
    };

    document.addEventListener('turbo:load', initCallback);
    document.addEventListener('turbolinks:load', initCallback);
    document.addEventListener('turbo:before-render', beforeRenderCallback);
    document.addEventListener('turbolinks:before-render', beforeRenderCallback);
    document.addEventListener('turbo:before-cache', beforeCacheCallback);
    document.addEventListener('turbolinks:before-cache', beforeCacheCallback);
  }

}

if (window.Alpine) {
  console.error('Alpine-turbo-drive-adapter must be included before AlpineJs');
} // Polyfill for legacy browsers


if (!Object.getOwnPropertyDescriptor(NodeList.prototype, 'forEach')) {
  Object.defineProperty(NodeList.prototype, 'forEach', Object.getOwnPropertyDescriptor(Array.prototype, 'forEach'));
} // To better suport x-cloak, we need to init the library when the DOM
// has been downloaded but before Alpine kicks in


beforeDomReady(() => {
  const bridge = new Bridge();
  bridge.init();
});


/***/ }),

/***/ "./node_modules/livewire-turbolinks/dist/livewire-turbolinks.js":
/*!**********************************************************************!*\
  !*** ./node_modules/livewire-turbolinks/dist/livewire-turbolinks.js ***!
  \**********************************************************************/
/***/ ((module, exports, __webpack_require__) => {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (factory) {
     true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
		__WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) :
    0;
}((function () { 'use strict';

    if (typeof window.livewire === 'undefined') {
      throw 'Livewire Turbolinks Plugin: window.Livewire is undefined. Make sure @livewireScripts is placed above this script include';
    }

    var firstTime = true;

    function wireTurboAfterFirstVisit() {
      // We only want this handler to run AFTER the first load.
      if (firstTime) {
        firstTime = false;
        return;
      }

      window.Livewire.restart();
    }

    function wireTurboBeforeCache() {
      document.querySelectorAll('[wire\\:id]').forEach(function (el) {
        const component = el.__livewire;
        const dataObject = {
          fingerprint: component.fingerprint,
          serverMemo: component.serverMemo,
          effects: component.effects
        };
        el.setAttribute('wire:initial-data', JSON.stringify(dataObject));
      });
    }

    document.addEventListener("turbo:load", wireTurboAfterFirstVisit);
    document.addEventListener("turbo:before-cache", wireTurboBeforeCache);
    document.addEventListener("turbolinks:load", wireTurboAfterFirstVisit);
    document.addEventListener("turbolinks:before-cache", wireTurboBeforeCache);
    Livewire.hook('beforePushState', state => {
      if (!state.turbolinks) state.turbolinks = {};
    });
    Livewire.hook('beforeReplaceState', state => {
      if (!state.turbolinks) state.turbolinks = {};
    });

})));


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
var exports = __webpack_exports__;
/*!*********************************************!*\
  !*** ./resources/js/livewire-turbolinks.ts ***!
  \*********************************************/


function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

__webpack_require__(/*! livewire-turbolinks */ "./node_modules/livewire-turbolinks/dist/livewire-turbolinks.js"); // Make Alpine be friends with Turbolinks and not
// keep dead elements around between requests


__webpack_require__(/*! alpine-turbo-drive-adapter */ "./node_modules/alpine-turbo-drive-adapter/dist/alpine-turbo-drive-adapter.esm.js"); // Any responses with model effects or notifications are highly indicative of some sort of data change, so we clear the cache


Livewire.hook('message.received', function (message, component) {
  var _a, _b, _c, _d, _e, _f;

  var effects = (_c = (_b = (_a = message === null || message === void 0 ? void 0 : message.response) === null || _a === void 0 ? void 0 : _a.serverMemo) === null || _b === void 0 ? void 0 : _b.data) === null || _c === void 0 ? void 0 : _c.modelEffects;

  if (_typeof(effects) === 'object' && Object.values(effects).length) {
    window.Turbolinks.clearCache();
  } else if (((_f = (_e = (_d = message === null || message === void 0 ? void 0 : message.response) === null || _d === void 0 ? void 0 : _d.effects) === null || _e === void 0 ? void 0 : _e.dispatches) !== null && _f !== void 0 ? _f : []).filter(function (dispatch) {
    return dispatch.event === 'lean-notify';
  }).length) {
    window.Turbolinks.clearCache();
  }
}); // We override the redirect() method on Livewire Components to first clear cache before making a redirect

Livewire.hook('component.initialized', function (component) {
  component.redirect = function (url) {
    window.Turbolinks.clearCache();
    window.Turbolinks.visit(url);
  };
});
})();

/******/ })()
;