export const direction = (_id) => {
    //_id -> ['example0', 'exmaple1']
    try{
        var page = window.location.search.substring(1);
        var pagesplit = page.split('&');


        var structure = [];
        if(!_id) return 'internal app error';
        for(var x = 0; x < _id.length ;x++){
            var identifie = _id[x];
            var lookingfor = false;
            for(var i = 0; i < pagesplit.length; i++){
                var identity = pagesplit[i].split('=');

                if(identity[0] == identifie){
                    lookingfor = true;
                    structure.push({
                        name: identifie,
                        find: true,
                        value: decodeURIComponent(identity[1])
                    });
                }
            }
            if(!lookingfor){
                structure.push({
                    name: identifie,
                    find: false,
                    value: 'no value'
                });
            }
        }

        return structure;
    }catch(error){
        return 'internal app error';
    }
}