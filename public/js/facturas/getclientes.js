 $(document).on('focusout', '#nit_cliente', function() 
 {


    fetch("https://consultareceptores.feel.com.gt/rest/action",{
        method: "POST",
        mode : "no-cors",
        body : JSON.stringify(
            {
                emisor_codigo : "INFILEDEMOINTERNO",
                emisor_clave : "DF49C2CC2B9D9306896B71EB4B5A74D8",
                nit_consulta : $("input[name='nit_cliente'] ").val(),
            }
        ),
    })
    .then(response => response.json())
    .then(data => console.log(data))
    
});
