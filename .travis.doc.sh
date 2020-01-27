if \
  [ "$TRAVIS_REPO_SLUG" == "Tarik02/laravel-mixin" ] && \
  [ "$TRAVIS_PULL_REQUEST" == "false" ] && \
  [ "$TRAVIS_PHP_VERSION" == "7.3" ] \
; then
  git config --global user.email "travis@travis-ci.org"
  git config --global user.name "travis-ci"
  git config --global push.default simple

  curl -O http://get.sensiolabs.org/sami.phar
  php sami.phar update sami.php

  git clone --quiet https://${GITHUB_TOKEN}@github.com/Tarik02/Tarik02.github.io $HOME/io-repo
  rm -rf $HOME/io-repo/laravel-mixin

  cp -r build $HOME/io-repo/laravel-mixin
  cd $HOME/io-repo
  git add laravel-mixin
  git commit -m "Travis: laravel-mixin documentation (Build: $TRAVIS_BUILD_NUMBER@$TRAVIS_TAG)"
  git push origin master
fi
