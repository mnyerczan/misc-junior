function $(id) {
    return document.getElementById(id);
}

window.addEventListener("load", () => {
    init();
    drag($("gat-00"));
    drag($("gat-01"));
    drag($("gat-02"));
    drag($("gat-03"));
    drag($("gat-04"));
    drag($("gat-05"));
    drag($("gat-10"));
    drag($("gat-11"));
    drag($("gat-12"));
    drag($("gat-13"));
    drag($("gat-14"));
    drag($("gat-15"));
    $("gat-submit").addEventListener("click", send);
    
});



function send() 
{
    leftContNodeList = $("gat-left").childNodes;
    rightContNodeList =  $("gat-right").childNodes;
    setPositions(leftContNodeList);
    setPositions(rightContNodeList);

    var gatNodes = Array.from(leftContNodeList).concat(Array.from(rightContNodeList));    

    var params = [];
    for(let i = 0; i < gatNodes.length; i++) {     
        params.push({
            "name" : gatNodes[i].innerHTML,
            "positionY" : (gatNodes[i].style.top).substring(0, (gatNodes[i].style.top).length -2)
        });
    }
    ping(JSON.stringify(params));
    
}
	
function ping(params) { 
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/gat/update", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.addEventListener("readystatechange", function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback(xhr);
        }
    }, false);
    xhr.send("params=" +params);
}


function feedback(xhr) {    
    $('feedback').innerHTML = xhr.responseText;
}


function init()
{
    var tables = $("gat-table").childNodes;

    var column = 0;
    var counter = 0;
    for(let i = 0; i < tables.length; i++) {
        if (tables[i].nodeType !== 3 ) {
            for(let j = 0; j < buttons.length; j++) {
                if (buttons[j].column === column) {
                    let div = document.createElement("div");
                    div.id = "gat-" + column + counter++;
                    div.innerHTML = buttons[j].name;
                    div.style.top = buttons[j].positionY + "px";  
                    tables[i].appendChild(div);                 
                }
            }
            column++;
            counter = 0;
        }
    }
}

function setPositions(nodes)
{   
    positions = [0, 70, 140, 210, 280, 350];
    for(let i = 0; i < nodes.length && i < positions.length; i++) {
        nodes[i].style.top = `${positions[i]}px`;            
    }
}

function drag(elmnt)
{
    var pos1 = 0, pos2 = 0;
    var rect = elmnt.parentNode.getBoundingClientRect();   
    var parentYStart = rect.y;
    var parentYEnd = rect.bottom - elmnt.clientHeight;
   

    elmnt.onmousedown = dragMouseDown;
    // Global varianble    
    zIndex = 10;

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos2 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) { 
        e.target.style.zIndex = zIndex;        
        e = e || window.event;
        e.preventDefault();        
        pos1 = pos2 - e.clientY;        
        pos2 = e.clientY;       

        if (parentYStart < e.clientY && parentYEnd > e.clientY && elmnt.offsetTop - pos1 >= 0)
            elmnt.style.top = (elmnt.offsetTop - pos1) + "px";     
            
        changeSiblings(e);        
    }

    function changeSiblings(e)
    {      
        var nodes = siblings(elmnt);     

        let j = 0;
        
        while(j < nodes.length && nodes[j].id !== elmnt.id){j++}        
    
        for(let i = 0; i < nodes.length; i++) {                            
            if (elmnt.getBoundingClientRect().y == nodes[i].getBoundingClientRect().y &&
                elmnt.id != nodes[i].id) {                
                let div = nodes[i];                
                // Ha az utolsó elem mögé kell szúrni.
                if (i == nodes.length) {           
                    elmnt.parentNode.appendChild(lmnt);
                    elmnt.style.top = nodes[nodes.length -1].positionY + "px";
                }
                // Hátrafelé mozgatás
                else if (i > j) {               
                    nodes[i].style.top = (parseInt(nodes[i].style.top) - 70) + "px";
                    elmnt.parentNode.insertBefore(elmnt, nodes[i + 1]);                                                            
                }
                // Előre mozgatás
                else if(j > i) {                                        
                    nodes[i].style.top = (parseInt(nodes[i].style.top) + 70) + "px";
                    elmnt.parentNode.insertBefore(elmnt,nodes[i]);
                }                              
            }            
        }
    }

    function siblings(element) {
        var siblings = [];
        var parent = element.parentNode;
        var child = parent.firstChild;
        while (child !== null) {
            if (child.nodeType ===1) {
                siblings.push(child);
            }
            child = child.nextSibling;
        }
        return siblings;
    }

    function closeDragElement() {
        // stop moving when mouse button is released:
        document.onmouseup = null;
        document.onmousemove = null;  
        zIndex++;
    }
}
