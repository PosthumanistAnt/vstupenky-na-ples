export {};

import { Lean } from './lean/lean';
import { Turbolinks } from 'turbolinks';
import { AlpineComponent } from '@leanadmin/alpine-typescript';

declare global {
    var Lean: Lean;
    var Livewire: any;
    var Turbolinks: Turbolinks;

    interface Window {
        Livewire: any;
        LivewireLoaded: boolean;
        initializeLean: Function;
        deferLoadingAlpine: Function;
        LivewireManagingDOM: any;
        LivewireManagedAlpineComponents: any;
        LeanAlpineMagicBootstrapped: any;
        skipAlpineTransitions: any;
        Alpine: any;
        Spruce: any;
        Lean: Lean;
        Turbolinks: Turbolinks;
    }

    interface LivewireComponent {
        id: string;
        set(property: string, value: any, defer?: boolean): void;
        get(property: string): any;
        call(method: string, ...properties: any): any;
        entangle(property: string): any;
        redirect(url: string): void;
        connection: any;
        fingerprint: any;
        serverMemo: any;
        effects: any;
    }

    interface Element {
        __livewire: LivewireComponent;
        __x: AlpineComponent;
    }
}
