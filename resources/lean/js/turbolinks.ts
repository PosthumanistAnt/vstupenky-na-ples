import { WriteAction } from "./lean/action";

window.Turbolinks = require("turbolinks");
Turbolinks.start();

type TurbolinksEventName = 'click' | 'load' | 'visit' | 'render' | 'request-end' | 'before-visit' | 'before-cache' | 'before-render' | 'request-start';
interface TurbolinksEvent extends Event { data: any }

const listen = (event: TurbolinksEventName, callback: (event: TurbolinksEvent) => void) => {
    return document.addEventListener('turbolinks:' + event, callback);
};

// Refresh Lean state on every page load
listen('load', event => {
    window.initializeLean();
});

// Empty links shouldn't trigger any Turbolinks action.
listen('click', event => {
    if ((event.target as Element).getAttribute('href') === '#') {
        return event.preventDefault();
    }
});

// Confirm navigating to different pages with unsaved changes
listen('before-visit', event => {
    if (Lean.forceRedirect) {
        Lean.forceRedirect = false;

        return;
    }

    Lean.actions
        ?.filter(action => (action as WriteAction).dirty)
        .map((action: WriteAction) => {
            // User already confirmed the action
            if (action.confirmedLeave) {
                return;
            }

            event.preventDefault();

            action.confirmLeave().then(confirmation => {
                if (confirmation) {
                    Turbolinks.visit(event.data.url); // Retry
                }
            });
        });
});

// Confirm closing tabs with unsaved changes
window.addEventListener('beforeunload', event => {
    Lean.actions
        ?.filter(action => (action as WriteAction).dirty)
        .map(_ => {
            event.preventDefault();
            event.returnValue = '';
        });
});

export default Turbolinks;
