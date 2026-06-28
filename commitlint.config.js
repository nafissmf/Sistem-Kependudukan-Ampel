/** @type {import('@commitlint/types').UserConfig} */
export default {
  extends: ['@commitlint/config-conventional'],
  rules: {
    // Sesuai dokumen "COMMIT FORMAT": feat, fix, refactor, style, test, docs, build
    'type-enum': [2, 'always', ['feat', 'fix', 'refactor', 'style', 'test', 'docs', 'build', 'chore', 'perf', 'ci']],
  },
};
