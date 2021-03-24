// In dev builds, the version is the latest commit hash.
// In production, it's the latest published git tag.

export const version = process.env.MIX_LEAN_VERSION;
export const environment = (version || '').includes('.') ? 'production' : 'development';
