<?php


echo "hello world";

?>



script {
  def deletedFiles = sh(script: 'git diff --diff-filter=D --name-only HEAD^ HEAD', returnStdout: true).trim().split('\n')
  if (deletedFiles.size() == 0) {
    sh "rsync -av --delete " + deletedFiles.join(' ') + " user@serveur_distant:destination/
    return
  }else{
    sh "rsync -r " user@serveur_distant:destination/"
  }
}