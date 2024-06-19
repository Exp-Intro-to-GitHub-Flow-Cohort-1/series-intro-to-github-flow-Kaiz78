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












pipeline {
    agent any
   
    stages {
        
        stage("Clone Code"){
            steps{
                git credentialsId:"token-git" ,url: "https://github.com/Exp-Intro-to-GitHub-Flow-Cohort-1/series-intro-to-github-flow-Kaiz78", branch: "main"
            }
        }
        
        stage('deploy') {
            steps {
                // Envoyer le code source depuis le serveur de build vers le serveur de production
                script {
                    echo 'Envoi du code au serveur'
                    def deletedFiles = sh(script: 'git diff --diff-filter=D --name-only HEAD^ HEAD', returnStdout: true).trim().split('\n')
                    def path = "/home/amine/series-intro-to-github-flow-Kaiz78/"
                    echo "${deletedFiles.size()}"

                    if (deletedFiles.size() == 1) {
                    sh """
                     cd ..
                     rsync -r test/* /home/amine/series-intro-to-github-flow-Kaiz78/
                    """
                    }
                    else {
                    sh """
                    cd ..
                    rm -rf ${path}${deletedFiles.join(' ' + path)}
                    rsync -r test/* /home/amine/series-intro-to-github-flow-Kaiz78/
                    """
                    }
                }
            }
        }


        
    }
}
zzzz