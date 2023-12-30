var gulp = require('gulp');
var shell = require('gulp-shell');

gulp.task('shell_npm_update', shell.task('npm update'));

gulp.task('shell_composer_self_update', shell.task('composer self-update'));
gulp.task('shell_composer_update', shell.task('composer update'));
gulp.task('shell_composer_update_prefer_lowest', shell.task('composer update --no-progress --prefer-dist --prefer-lowest --prefer-stable'));
gulp.task('shell_test', shell.task('vendor\\bin\\tester tests -s -p php'));

gulp.task('shell_netteCodeChecker', shell.task('php ..\\..\\nette-code-checker\\code-checker -d src --strict-types --no-progress --ignore expected'));
gulp.task('shell_netteCodeCheckerFIX', shell.task('php ..\\..\\nette-code-checker\\code-checker -d src --strict-types --no-progress --ignore expected --fix'));
gulp.task('shell_netteCodingStandard', shell.task('php ..\\..\\nette-coding-standard\\ecs check src tests --preset php81'));
gulp.task('shell_netteCodingStandardFIX', shell.task('php ..\\..\\nette-coding-standard\\ecs check src tests --preset php81 --fix'));

gulp.task('shell_phpstan', shell.task('c:\\www\\phpstan-nette\\vendor\\bin\\phpstan.bat analyse src tests --level=0 --memory-limit=4000M'));

gulp.task('default', gulp.series('shell_npm_update', 'shell_composer_self_update', 'shell_composer_update'));
gulp.task('installDependencies', gulp.series('shell_npm_update', 'shell_composer_self_update'));
gulp.task('test', gulp.series(['shell_test']));
