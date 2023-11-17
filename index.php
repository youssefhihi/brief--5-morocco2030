<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="images/.png" />
    <title>Morocco 2023</title>
</head>


<body>
<?php

$cnc = mysqli_connect("localhost", "root", "", "worldcup");
$groups = "SELECT * FROM groups";
$groups_result = mysqli_query($cnc, $groups);

?>
     <!-- Popup -->
     <div id="popup"
      class="fixed w-full h-full top-0 left-0  items-center flex justify-center bg-black bg-opacity-50 hidden z-20">
      <!-- Popup content -->
      <div id="myPopup" class="bg-white w-72 pb-10 pt-10  flex flex-col justify-start items-center gap-4 overflow-y-auto md:h-fit">
        <img id="imgEquipe"  >
      <h4 id="nomEquipe" class=" font-sans font-semibold"></h4>
      <p id="capitalEquipe" ></p>
            <p id="continentEquipe"  ></p>
            <p id="ordreFifa"  ></p>
      </div>
    </div>
    <!-- End of Popup -->

    <div class="text-center flex mt-7">
        <img src="images/logo.png" alt="">
        <h1 class="font-semibold text-3xl"> le calendrier officiel des groupes de FIFA World Cup <span class="text-red-600">Morocco 2030</span>.</h1>
    </div>
    <form action="" method="post">
    <div class="mt-2 h-28 flex space-x-5  justify-around pt-8 ">
        <button name="group" value="all" class="filter-button bg-white border rounded-xl border-green-500 text-green-500 h-14 w-28  hover:bg-green-400  ease-in-out duration-300 hover:text-white active:bg-green-400">All</button>
        <?php
        $selected_group_id = 'all';
            while ($groups_row = mysqli_fetch_assoc($groups_result)) {
                $group_id = $groups_row["group_id"];
                $nom_group = $groups_row["nom_group"];
        ?>
         <button name="group" value="<?php echo $group_id; ?>"
                class="filter-button bg-white border rounded-xl border-green-500 text-green-500 h-14 w-28 hover:bg-green-400 ease-in-out duration-300 hover:text-white focus:bg-green-400 active:text-red clicked"  onclick="handleButtonClick(this)"><?php echo $nom_group; ?></button>
            <?php
            }
            ?>
    </div> 
    </form>
    <?php
    if (isset($_POST["group"]) && $_POST["group"] != 'all' ) {
        $selected_group_id = $_POST["group"];
        $grp = "SELECT * FROM equipe WHERE groupe_id = $selected_group_id";
        $grp_result = mysqli_query($cnc, $grp);
    ?>
    <div class=" grid grid-cols-1 px-10  bg-white shadow-md rounded-md W-96 hover:shadow-lg ">
        <table class="table-auto border-separate border-spacing-2 border border-slate-400">
        <thead >
        <tr >
            <th  class="border border-slate-300">Drapeau</th>
            <th  class="border border-slate-300">Nom</th>
            <th class="border border-slate-300">Continent</th>
            <th class="border border-slate-300">Ordre FIFA</th>
         </tr>
        </thead>
        <tbody>
            <tr>
    
    
        <?php
        
        
        
       
        while ($grp_row = mysqli_fetch_assoc($grp_result)) {
            $src = $grp_row["drapeau_equipe"];
            $nom = $grp_row["nom_equipe"];
            $continent = $grp_row["continent_equipe"];
            $ordre_fifa = $grp_row["ordre_fifa"];
        
            echo '<div class="flex  gap-5">';
            echo "<td> <img src=\"$src\" alt=\"\" class=\"w-14\"></td>";
            echo '<td> <h4 class="font-sans font-somibold border border-slate-300">' . $nom . '</h4> </td>';
            echo '<td> <h4 class="font-sans font-somibold border border-slate-300">' . $continent . '</h4> </td>';
            echo '<td> <h4 class="font-sans font-somibold border border-slate-300">' . $ordre_fifa . '</h4> </td>';
            echo '</div></tbody></tr>';
        
       
        }
    echo '</table>' ;   
    echo'</div>';
    
    
    echo'<div id="allgroups" >';
    
    }elseif ($selected_group_id === 'all'){
    $groups = "SELECT * FROM groups";
    $groups_result = mysqli_query($cnc, $groups);
    echo' <div class="grid grid-cols-4  gap-4">';
    while ($groups_row2 = mysqli_fetch_assoc($groups_result)) {
        $id = $groups_row2["group_id"];
        $nom_group = $groups_row2["nom_group"];
        $stade = $groups_row2["stade"];

        
        echo '<div class="flex flex-col  bg-white p-4 shadow-md rounded-md w-72   ">';
        echo '<h3 class="text-lg font-semibold mb-2  text-center underline">' . $nom_group . '</h3>';
        echo '<div class="w-full grid grid-rows-2 grid-cols-2 justify-around">';
        $equipe = "SELECT * FROM equipe WHERE groupe_id = $id";
        $equipe_result = mysqli_query($cnc, $equipe);
        while ($equipe_row = mysqli_fetch_assoc($equipe_result)) {
            $src = $equipe_row["drapeau_equipe"];
            $nom = $equipe_row["nom_equipe"];   
            $continent = $equipe_row["continent_equipe"]; 
            $ordre_fifa = $equipe_row["ordre_fifa"];
            $capital = $equipe_row["capital_equipe"]; 
            
            echo '<img src="'. $src . '" alt="" class="w-14 cursor-pointer" onclick="openPopup(\'' . $src . '\',\'' . $nom . '\',\'' . $continent . '\',\''. $capital . ' \',  \'' . $ordre_fifa .  '\')">';

            echo '<h4 class="font-sans font-somiboldcursor-pointer" onclick="openPopup(\'' . $src . '\',\'' . $nom . '\', \'' . $continent . '\',\''. $capital . ' \', \'' . $ordre_fifa . '\')">' . $nom .'</h4>';
          
         
        }
        echo '</div>';
        echo '<p class="text-center text-xl text-gray-500 hover:text-red-500 ease-in-out duration-300"> ' . $stade . '</p>';
        echo '</div>';
    }}
    echo'</div>';
echo' </div>';

   ?> 

   

   
    
    </div>

    
    

<script>
    // Open the popup
    function openPopup(img, nom, continent,capital, ordreFifa) {
            document.getElementById("imgEquipe").src = img;
            document.getElementById("nomEquipe").innerText = nom;
            document.getElementById("continentEquipe").innerText = "continent : " + continent;
            document.getElementById("capitalEquipe").innerText = "capital : " + capital;
            document.getElementById("ordreFifa").innerText = "Classement FIFA : " + ordreFifa;
            document.getElementById("popup").classList.remove("hidden");
    }
  
  // Close the popup when clicking outside the popup content
  window.onclick = function (event) {
    var popup = document.getElementById("popup");
    if (event.target == popup) {
      popup.classList.add("hidden");
    }
};

function remove() {
    var allGroupsElement = document.getElementById("allgroups");
    if (allGroupsElement) {
        allGroupsElement.classList.add('hidden');
    }
}
</script>
<script>
  function handleButtonClick(button) {
    
    button.classList.add('clicked');
  }
    </script>
</body>

</html>