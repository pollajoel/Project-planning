
pipeline {
    agent any
    environment { 
      IMAGE_NAME = "alpinehelloworld"
    }

    stages {
        
            stage("Build") {
                steps {
                    sh '''
                            echo '- Clean Container..';
                        '''
                }
            }
        
            stage("Deploy") {
                steps {
                        sh '''
                               echo '- Deploy Apps...';
                            '''
                }
            }
        
            stage("Test") {
                steps {
                    sh '''
                            echo '- Applied All Test...'
                       '''
                }           
            }
        
    }

}
