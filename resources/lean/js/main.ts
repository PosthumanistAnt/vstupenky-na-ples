import { wireReplace, blockListeners, parseResponses, parseInitialDOM, observeModelChanges } from './livewire';

// We register our class-based Alpine components.
import './components';

// We import Alpine, with a few changes to make it work well Lean.
import './alpine';

// We import the Lean runtime which keeps track of the frontend data model.
import './lean';

// The wire:replace directive lets us tell Livewire to replace
// entire subtrees of the DOM, rather than of diffing them.
wireReplace();

// This tells some listeners to wait when the Lean state is being updated.
blockListeners();

// These hooks make make Lean aware of the Livewire state.
parseResponses();
parseInitialDOM();
observeModelChanges();
