import { AlpineComponent } from '@leanadmin/alpine-typescript';

export default class DarkmodeToggle extends AlpineComponent {
    public theme: string|null = null;

    /** Used for determining the transition direction. */
    public previousTheme: string|null = null;

    public browserTheme(): string {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    public switchTheme(theme: string): void {
        this.$nextTick(() => this.previousTheme = this.theme);

        this.theme = theme;

        window.localStorage.setItem('leanTheme', theme);

        this.updateDocumentClass(theme);
    }

    public updateDocumentClass(theme: string): void {
        if (theme === 'dark') {
            if (! document.documentElement.classList.contains('lean-dark')) {
                document.documentElement.classList.add('lean-dark');
            }
        } else {
            if (document.documentElement.classList.contains('lean-dark')) {
                document.documentElement.classList.remove('lean-dark');
            }
        }
    }

    public resetTheme(): void {
        this.updateDocumentClass(this.browserTheme());

        window.localStorage.removeItem('leanTheme');

        this.theme = null;
    }

    public storedTheme(): string|null {
        return window.localStorage.getItem('leanTheme') || null;
    }

    public themeIs(theme: string|null): boolean {
        if (! theme) {
            return ! this.storedTheme();
        }

        return this.storedTheme() && (theme === this.theme);
    }

    public loadStoredTheme(): void {
        if (this.storedTheme()) {
            this.switchTheme(this.storedTheme());
        }
    }

    public registerListener(): void {
        window
            .matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', () => {
                if (! this.theme) {
                    this.updateDocumentClass(this.browserTheme());
                }
            });
    }

    public init(): void {
        this.loadStoredTheme();
        this.registerListener();
    }
}
