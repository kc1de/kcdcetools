<?php

/*
*  DCE TOOLS
*  - DCE Lib
*/

//Get regular fields of selected dce
function getDCEFields($sourceconn,$sourcedce,$showoutput)
{
$sql = "SET CHARACTER SET utf8;";
executenonquery($sourceconn,$sql);
$sql = "SET NAMES 'utf8';";
executenonquery($sourceconn,$sql);

$sql = "SELECT * FROM `tx_dce_domain_model_dcefield` WHERE deleted=0 and parent_dce = ".$sourcedce." Order By sorting;";
$sourceresult = getresult($sourceconn,$sql);

$dcerows = array();
$alldcerows = array();

if ($sourceresult->num_rows > 0) {
    // output data of each row
    while($row = $sourceresult->fetch_assoc()) {
      $dcerows[]= $row;
    }
}

if($showoutput) {
echo "<h3>DCE Elemente</h3>\n";

 echo "<table>\n";
  echo "<thead><tr>\n";
   echo "<td>UID</td><td>Title</td><td>Type</td><td>Variable</td><td>Parent_Field</td>";
   echo "</tr></thead>\n";
}

 foreach ( $dcerows as $row)
    {
    $alldcerows[]=$row;
    if ($row[type]==0)
     {
        if($showoutput) {  echo "<tr class='dcenormalfield'>\n";}
     }

    if ($row[type]==1)
     {
        if($showoutput) {  echo "<tr class='dcetabfield'>\n";}
     }

    if ($row[type]==2)
     {
        if($showoutput) { echo "<tr class='dcesectionfield'>\n";}
     }

    if($showoutput) { echo "<td>" . $row[uid] . "</td><td>" . $row[title] . "</td><td>" . $row[type] . "</td><td>" . $row[variable] . "</td><td>" . $row[parent_field] . "</td>";}

    if($row[type]==2)
      {
      $ret=getSectionFields($row[uid],$sourceconn,$showoutput);
      foreach ($ret as $trow)
        {
          $alldcerows[]=$trow;
        }
      }
      if($showoutput) {  echo "</tr>\n";}
    }
    if($showoutput) {  echo "</table>\n"; }
 return $alldcerows;
}



//Get dce section fields
function getSectionFields($parent,$conn,$showoutput)
{
$sectionrows = array();
$sql = "SELECT * FROM `tx_dce_domain_model_dcefield` WHERE deleted=0 and  parent_field = ".$parent." Order By sorting;";

$result = getresult($conn,$sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $sectionrows[]= $row;
    }
}
else
{
   echo "<h1>Kein Ergebnis Keine Sektionfelder</h1>";
}

 if($showoutput) {
 foreach ( $sectionrows as $row) {
   echo "<tr class='sectionfields'>\n";

      echo "<td>" . $row[uid] . "</td><td>" . $row[title] . "</td><td>" . $row[type] . "</td><td>" . $row[variable] . "</td><td>" . $row[parent_field] . "</td>";

      echo "</tr>\n";
      }
 }
return  $sectionrows;
}

//Get dce title
function getDCETitle($sourceconn,$sourcedce)
{
$sql = "SET CHARACTER SET utf8;";
executenonquery($sourceconn,$sql);
$sql = "SET NAMES 'utf8';";
executenonquery($sourceconn,$sql);

$sql = "SELECT * FROM tx_dce_domain_model_dce where uid=". $sourcedce .";";
$sourceresult = getresult($sourceconn,$sql);
if ($sourceresult->num_rows > 0) {
    // output data of each row
    while($row = $sourceresult->fetch_assoc()) {
        $sourcedcetitle= $row["title"];
    }
}
return $sourcedcetitle;
}

//Get dce row
function getDCERow($sourceconn,$sourcedce)
{
// Elemente oberster Ebene des DCE ermittlen
$sql = "SET CHARACTER SET utf8;";
executenonquery($sourceconn,$sql);
$sql = "SET NAMES 'utf8';";
executenonquery($sourceconn,$sql);

$sql = "SELECT * FROM tx_dce_domain_model_dce where  deleted=0 and  uid=". $sourcedce .";";
$sourceresult = getresult($sourceconn,$sql);
if ($sourceresult->num_rows > 0) {
    // output data of each row
    while($row = $sourceresult->fetch_assoc()) {
      $dcerow= $row;
    }
}
return $dcerow;
}

//Insert dce definition row into tx_dce_domain_model_dce table
function insertdcerow($targetconn,$dcerow)
{
// Elemente oberster Ebene des DCE ermittlen
$sql = "SET CHARACTER SET utf8;";
executenonquery($targetconn,$sql);
$sql = "SET NAMES 'utf8';";
executenonquery($targetconn,$sql);


$sql="INSERT INTO `tx_dce_domain_model_dce`(
 `pid`, `title`, `fields`, `wizard_enable`
, `wizard_category`, `wizard_description`, `wizard_icon`, `wizard_custom_icon`, `template_type`
, `template_content`, `template_file`, `cache_dce`, `show_access_tab`, `show_media_tab`
, `show_category_tab`, `hide_default_ce_wrap`, `flexform_label`, `use_simple_backend_view`, `backend_view_header`
, `backend_view_bodytext`, `backend_template_type`, `backend_template_content`, `backend_template_file`, `template_layout_root_path`
, `template_partial_root_path`, `palette_fields`, `enable_detailpage`, `detailpage_identifier`, `detailpage_template_type`
, `detailpage_template`, `detailpage_template_file`, `enable_container`, `container_item_limit`, `container_template_type`
, `container_template`, `container_template_file`, `tstamp`, `crdate`, `cruser_id`
, `deleted`, `hidden`,  `sorting`
, `t3ver_oid`,  `t3ver_wsid`,  `t3ver_state`
, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3ver_move_id`, `t3_origuid`
)
VALUES (" .
$targetconn->real_escape_string($dcerow['pid'])
. ",'"
. $targetconn->real_escape_string($dcerow['title'])
. "','"
. $targetconn->real_escape_string($dcerow['fields'])
. "','"
. $targetconn->real_escape_string($dcerow['wizard_enable'])
. "','"
. $targetconn->real_escape_string($dcerow['wizard_category'])
. "','"
. $targetconn->real_escape_string($dcerow['wizard_description'])
. "','"
. $targetconn->real_escape_string($dcerow['wizard_icon'])
. "','"
. $targetconn->real_escape_string($dcerow['wizard_custom_icon'])
. "','"
. $targetconn->real_escape_string($dcerow['template_type'])
. "','"
. $targetconn->real_escape_string($dcerow['template_content'])
. "','"
. $targetconn->real_escape_string($dcerow['template_file'])
. "','"
. $targetconn->real_escape_string($dcerow['cache_dce'])
. "','"
. $targetconn->real_escape_string($dcerow['show_access_tab'])
. "','"
. $targetconn->real_escape_string($dcerow['show_media_tab'])
. "','"
. $targetconn->real_escape_string($dcerow['show_category_tab'])
. "','"
. $targetconn->real_escape_string($dcerow['hide_default_ce_wrap'])
. "','"
. $targetconn->real_escape_string($dcerow['flexform_label'])
. "',"
. $targetconn->real_escape_string($dcerow['use_simple_backend_view'])
. ",'"
. $targetconn->real_escape_string($dcerow['backend_view_header'])
. "','"
. $targetconn->real_escape_string($dcerow['backend_view_bodytext'])
. "','"
. $targetconn->real_escape_string($dcerow['backend_template_type'])
. "','"
. $targetconn->real_escape_string($dcerow['backend_template_content'])
. "','"
. $targetconn->real_escape_string($dcerow['backend_template_file'])
. "','"
. $targetconn->real_escape_string($dcerow['template_layout_root_path'])
. "','"
. $targetconn->real_escape_string($dcerow['template_partial_root_path'])
. "','"
. $targetconn->real_escape_string($dcerow['palette_fields'])
. "',"
.$targetconn->real_escape_string($dcerow['enable_detailpage'])
. ",'"
. $targetconn->real_escape_string($dcerow['detailpage_identifier'])
. "','"
. $targetconn->real_escape_string($dcerow['detailpage_template_type'])
. "','"
. $targetconn->real_escape_string($dcerow['detailpage_template'])
. "','"
. $targetconn->real_escape_string($dcerow['detailpage_template_file'])
. "',"
. $targetconn->real_escape_string($dcerow['enable_container'])
. ","
. $targetconn->real_escape_string($dcerow['container_item_limit'])
. ",'"
. $targetconn->real_escape_string($dcerow['container_template_type'])
. "','"
. $targetconn->real_escape_string($dcerow['container_template'])
. "','"
. $targetconn->real_escape_string($dcerow['container_template_file'])
. "',"
. $targetconn->real_escape_string($dcerow['tstamp'])
. ","
. $targetconn->real_escape_string($dcerow['crdate'])
. ","
. $targetconn->real_escape_string($dcerow[ 'cruser_id'])
. ","
. $targetconn->real_escape_string($dcerow['deleted'])
. ","
. $targetconn->real_escape_string($dcerow['hidden'])
. ","
. $targetconn->real_escape_string($dcerow['sorting'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_oid'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_wsid'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_state'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_stage'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_count'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_tstamp'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_move_id'])
. ","
. $targetconn->real_escape_string($dcerow['t3_origuid'])
. ")";

$lastid=insertandgetid($targetconn,$sql);
return $lastid;
}

//Insert dce field row into tx_dce_domain_model_dcefield table
function insertdceelement($targetconn,$dcerow)
{
$sql = "SET CHARACTER SET utf8;";
executenonquery($targetconn,$sql);
$sql = "SET NAMES 'utf8';";
executenonquery($targetconn,$sql);

$sql="INSERT INTO `tx_dce_domain_model_dcefield`(
 `pid`, `title`, `variable`, `type`
, `configuration`, `map_to`, `new_tca_field_name`, `new_tca_field_type`, `section_fields`
, `section_fields_tag`, `parent_dce`, `parent_field`, `tstamp`, `crdate`
, `cruser_id`, `deleted`, `hidden` 
, `sorting`, `t3ver_oid`,  `t3ver_wsid`
, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3ver_move_id`
, `t3_origuid`
) VALUES ("
. $targetconn->real_escape_string($dcerow['pid'])
. ",'"
. $targetconn->real_escape_string($dcerow['title'])
. "','"
. $targetconn->real_escape_string($dcerow['variable'])
. "','"
. $targetconn->real_escape_string($dcerow['type'])
. "','"
. $targetconn->real_escape_string($dcerow['configuration'])
. "','"
. $targetconn->real_escape_string($dcerow['map_to'])
. "','"
. $targetconn->real_escape_string($dcerow['new_tca_field_name'])
. "','"
. $targetconn->real_escape_string($dcerow['new_tca_field_type'])
. "','"
. $targetconn->real_escape_string($dcerow['section_fields'])
. "','"
. $targetconn->real_escape_string($dcerow['section_fields_tag'])
. "',"
. $targetconn->real_escape_string($dcerow['parent_dce'])
. ","
. $targetconn->real_escape_string($dcerow['parent_field'])
. ","
. $targetconn->real_escape_string($dcerow['tstamp'])
. ","
. $targetconn->real_escape_string($dcerow['crdate'])
. ","
. $targetconn->real_escape_string($dcerow['cruser_id'])
. ","
. $targetconn->real_escape_string($dcerow['deleted'])
. ","
. $targetconn->real_escape_string($dcerow['hidden'])
. ","
. $targetconn->real_escape_string($dcerow['sorting'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_oid'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_wsid'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_state'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_stage'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_count'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_tstamp'])
. ","
. $targetconn->real_escape_string($dcerow['t3ver_move_id'])
. ","
. $targetconn->real_escape_string($dcerow['t3_origuid'])
. ")";

$lastid=insertandgetid($targetconn,$sql);
return $lastid;
}
?>
