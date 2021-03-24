import { Lean } from './lean';
import { version, environment } from './build';

// We instantiate Lean and set the build information
window.Lean = new Lean;
window.Lean.version = version;
window.Lean.environment = environment;

export default window.Lean;
