import 'livewire-turbolinks';

// Make Alpine be friends with Turbolinks and not
// keep dead elements around between requests
import 'alpine-turbo-drive-adapter';

// Any responses with model effects or notifications are highly indicative of some sort of data change, so we clear the cache
Livewire.hook('message.received', (message: { [key: string]: any }, component: LivewireComponent) => {
    let effects = message?.response?.serverMemo?.data?.modelEffects;

    if (typeof effects === 'object' && Object.values(effects).length) {
        Turbolinks.clearCache();
    } else if ((message?.response?.effects?.dispatches ?? []).filter(dispatch => dispatch.event === 'lean-notify').length) {
        Turbolinks.clearCache();
    }
})

// We override the redirect() method on Livewire Components to first clear cache before making a redirect
Livewire.hook('component.initialized', (component: LivewireComponent) => {
    component.redirect = url => {
        Turbolinks.clearCache();

        Lean.redirect(url, true);
    }
});
