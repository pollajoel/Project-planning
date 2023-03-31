import React, {useEffect, useState} from 'react';
import {createRoot} from "react-dom/client";

 function Posts({usersid}) {
const [ users, setUsers ]   = useState([])
const [loading, setLoading] = useState( true )
useEffect(()=>{
    fetchData()
}, [])
const fetchData = async()=>{
  
    try{
        var requestOptions = {
            method: 'GET',
            redirect: 'follow'
          };
          
          const data = await fetch("/api", requestOptions)
            .then(response => response.json())

        if( data )
        {
            setUsers (data.users);
            setLoading( false )
        }
    }catch( error ){
        console.log( error )
    }
   
}
  return (
    <div>
       {loading && <>Chargement...</>}
       {!loading  && <div>
            <ol className="p-4">

                {
                       users.map((user, index)=>  <li className="text-body-color mb-4 flex text-base"  key={index}>
                      <span className="relative z-10 mr-2 flex h-6 w-full max-w-[24px] items-center justify-center rounded text-base text-white"
                      >
                        <span
                          className="bg-primary absolute top-0 left-0 z-[-1] h-full w-full -rotate-45 rounded"
                        ></span>
                        {user.name}
                      </span>
                     {user.firsname}
                    </li>)

                }
            </ol>
        </div>}
    </div>
  )
}



class PostsElement extends HTMLElement{
    connectedCallback () {
        const root = createRoot(this)
        const usersid = this.dataset.usersid
        console.log( this.dataset )
        root.render(<Posts usersid={usersid}/>)
    }
}

customElements.define('posts-component', PostsElement)