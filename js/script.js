document.addEventListener('DOMContentLoaded',function(){
    //controle d'éxistance
    if(document.getElementById('avatar')){
        //Ecoute de l'evenement
        document.getElementById('avatar').addEventListener('change',function(event){
            //je récupère les infos du fichier
            let fichier = event.target.files[0];
            let reader = new FileReader();
            if(fichier){
                reader.readAsDataURL(fichier);
                reader.onload = function(e){
                    //je l'utilise pour la source de la source mon image
                    document.getElementById('preview').setAttribute('src', e.target.result);
                }
            }
        });

        //Drag and drop (glisser déposer)
        document.querySelector('html').addEventListener('dragover', function(e){
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('preview').style.border='5px dashed blue';
        });

        document.querySelector('html').addEventListener('dragleave', function(e){
            e.preventDefault();
            e.stopPropagation();
            document.getElementById.style.border = 'none';
        });

        document.querySelector('html').addEventListener('drop', function(e){
            e.preventDefault();
            e.stopPropagation();
            document.getElementById.style.border = 'none';
        });

        document.querySelector('#preview').addEventListener('drop', function(e){
            //je récupère ce qui est déposé
            let fichier = e.dataTransfer.files;
            //j'alimente l'input de type file avec ce fichier
            document.getElementById('avatar').files = fichier;
            //je vais déclencher l'évènement 'change'
            let evenement = new CustomEvent('change');
            document.getElementById('avatar').dispatchEvent(evenement);
        })
    }
    //-------- Gestion du tchat en ajax ---------
    let lastID = 0;//dercier id du message à afficher
    let timer_messages = null; //Timer pour la mise à jour de la conversation
    let timer_users = null;//Timer pour la mise à jour des utilisateurs

    function ajax(parametres, traitement){
        let url= 'inc/process.php';
        let params = new FormData();
        for(let i in parametres){
            params.append(i, parametres[i]);
        }
        let args = {
            method : 'POST',
            body : params
        }
        fetch(url, args)
            .then(function(reponse){
                return reponse.json();
            })
           .then(traitement);
    } 


    function getUsers(){
        ajax({action : 'getUsers'},function(datas){
            // console.log(datas.users);
            let html = datas.nbUsers + 'utilisateur' +((datas.nbUsers>1) ? 's' : '');
            if(datas.nbUsers > 0){
                for(let i = 0; i < datas.nbUsers; i++){
                    html += `
                    <div class="row mt-2">
                        <div class="col-4">
                            <img src="avatars/${datas.users[i].avatar}" alt="${datas.users[i].login}" class="img-fluid">
                        </div>
                        <div class="col-8 d-flex align-items-center">
                            ${datas.users[i].login}
                        </div>
                    </div>
                    `
                }
            }

            document.getElementById('users').innerHTML = html;
        });
    }
        function getMessages(option){
            if(typeof option != 'undefined' && option == 'start'){
                ajax({
                    action : 'getIdMemoire'
                },function(datas){
                    lastID = datas.idMemoire;
                    getMessages();
                });
            }
            ajax({
                action : 'getMessages',
                lastID : lastID
            },function(datas){
                if(datas.nbMessages > 0){
                    let html = ''; 
                for(let i = 0; i < datas.nbMessages; i++) {

                   html += `
                    <div class="d-flex align-items-center">
                        <p class="avatar">
                            <img src="avatars/${datas.messages[i].avatar}" alt="${datas.messages[i].login} "class="img-fluid">
                        </p>
                        <p class="ml-2 text-secondary">${datas.messages[i].date_message} |
                        <span class="capitilize ml-2">${datas.messages[i].login}</span>
                        <br>${datas.messages[i].message}</p>
                    </div>
                    `;
                    lastID = datas.messages[i].id_message;
                }
                document.getElementById('conversation').innerHTML += html;
                document.getElementById('conversation').scrollTop = document.getElementById('conversation').scrollHeight ;

            }
        });
    }
        function getLastId(){
            ajax({action: 'getLastId'}, function(datas){
                lastID = datas.lastID;
                getMessages('start');//Pour que les anciens messages apparaissent lors de la connexion
             })   
        }
    //Je verifie que je suis sur la page du tchat
    if(document.getElementById('conversation')){
        getUsers();
        timer_users = setInterval(getUsers, 4000);//appelle les utilisateurs toutes les 4 secondes
        getLastId();
        timer_messages = setInterval(getMessages, 2000);

        document.getElementById('formulaire').addEventListener('submit', function(e){
            e.preventDefault();
            let message = document.getElementById('phrase').value;
            if(message.trim() != ''){
                
                clearInterval(timer_messages); //je stoppe le timer qui rafraichis les messages
                ajax({
                    action: 'addMessage',
                    message : message
                },function(datas){
                    getMessages();
                    timer_messages = setInterval(getMessages, 2000);
                });
            }
            document.getElementById('phrase').value = '';
        });
    }

    function userProfile(){
        ajax({action : 'userProfile'},
        function(datas){
                for(let i = 0; i < datas.nbUsers; i++){
                document.getElementById('cardProfile').innerHTML = 
                `
                <img src="avatars/${datas.user[i].avatar}" alt="${datas.user[i].login}" class="card-img-top">
                <button class ="btn btn-info" id="updateAvatar"> Modifier mon avatar</button>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dark text-center"> ${datas.user[i].login}</li>
                    <li class="list-group-item bg-dark text-center"> ${datas.user[i].email}</li>
                    <li class="list-group-item bg-dark text-center"><button class ="btn btn-info" id="updatePassword"> Modifier mon mot de passe</button></li>

                </ul>
                `;
            }
        })
    }

    if(document.getElementById('profile')){
        userProfile();
        document.getElementById('updateAvatar').addEventListener('click' ,(function(){
                alert('ok');
            }))
        
    }
    

});//fin du DOM chargé