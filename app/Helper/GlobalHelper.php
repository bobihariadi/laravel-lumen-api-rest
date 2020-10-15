<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GlobalHelper {

    public static function index($input) {
        //initial query generate to show
        DB::enableQueryLog();

        $connect  = DB::connection($input["db"])->table($input["table"]);

        // ======= SELECT =======
        // selected field
        /*
        "selected":[
            "field","other field","other field"
        ]
        */
        if (!empty($input["selected"])) {
            $result  = $connect->select($input["selected"]);
        }

        // raw select using other agregate (able more than raw field select)
        /*
        "raw":[
            ["count(id) as total"],
            ["sum(id) as jumlah"]
        ]
        */
        if (!empty($input["raw"])) {
            $arrRaw = $input["raw"];
            if(is_array($arrRaw[0])){   
                $dataraw = "";             
                foreach($arrRaw as $raw){
                    $dataraw .= $raw[0].",";
                }
                $arrRaw = substr($dataraw,0,-1);
            }else{
                if(is_array($arrRaw)){
                    $arrRaw = $arrRaw[0];
                }
            }
            $connect->select(DB::raw($arrRaw));
        }

        // distinct select
        /*
        "distinct":["views","id"]
        */
        if(!empty($input["distinct"])) { 
            $connect->distinct($input["distinct"]);
        }

        // ========= JOIN ==========
        // join Parameter
        /*
        "join":[
            {"table": "users",
            "field1":"users.id",
            "field2": "posts.id" }
        ]
        */
        if (!empty($input["join"])) {            
            foreach ($input["join"] as $list) {
              $connect->join(strtoupper($list["table"]), strtoupper($list["field1"]), '=', strtoupper($list["field2"]));
            }
        }

        // Left Join Parameter
        /*
        "leftjoin":[
            {"table": "users",
            "field1":"users.id",
            "field2": "posts.id" }
        ]
        */
        if (!empty($input["leftjoin"])) {            
            foreach ($input["leftjoin"] as $list) {
              $connect->leftJoin(strtoupper($list["table"]), strtoupper($list["field1"]), '=', strtoupper($list["field2"]));
            }
        }

        // Right Join Parameter
        /*
        "rightjoin":[
            {"table": "users",
            "field1":"users.id",
            "field2": "posts.id" }
        ]
        */
        if (!empty($input["rightjoin"])) {            
            foreach ($input["rightjoin"] as $list) {
              $connect->rightJoin(strtoupper($list["table"]), strtoupper($list["field1"]), '=', strtoupper($list["field2"]));
            }
        }
          

        // ======== WHERE =========
        // where parameter
        /* 
        "where": [
            ["field","=","value"]
        ] 
        */
        if(!empty($input["where"][0])) {
            $connect->where($input["where"]);
        }

        // where in parameter (able more than one where in paramaeters)
        /*
        "whereIn": [        
            ["field", ["value","value"]],
            ["other field",["value","value","value"]]        
        ]
       */
        if(!empty($input["whereIn"][0])) {
            $arrWhere = $input["whereIn"];
            if(is_array($arrWhere[0])){
                foreach($arrWhere as $in){       
                    $connect->whereIn(strtoupper($in[0]), $in[1]);
                }
            }else{                
                $connect->whereIn(strtoupper($arrWhere[0]), $arrWhere[1]);
            }
        }

        // where not in parameter (able more than one where not in paramaeters)
        /*
        "whereNotIn": [        
            ["field", ["value","value"]],
            ["other field",["value","value","value"]]        
        ]
       */
        if(!empty($input["whereNotIn"][0])) {
            $arrWhere = $input["whereNotIn"];
            if(is_array($arrWhere[0])){
                foreach($arrWhere as $in){ 
                    $connect->whereNotIn(strtoupper($in[0]), $in[1]);
                }
            }else{                
                $connect->whereNotIn(strtoupper($arrWhere[0]), $arrWhere[1]);
            }
        }

        // where raw parameter used when where has logic
        /*
        "whereraw": "field > 1"
        */
        if (isset($input["whereraw"])) {
            $connect->whereRaw($input["whereraw"]);
        }

        // filter parameter
        /*
        "filter":[
            {"property": "field table","operator":"like","value": "value table" }
        ]
        */
        if (!empty($input["filter"])) {
            $search   = $input["filter"];
            if (!is_array($search)) {
                $search = json_decode($search, TRUE);
            }
            foreach ($search as $value) {
              if ($value["operator"] == "like")
                $connect->Where(strtoupper($value["property"]),$value["operator"],"%".strtoupper($value["value"])."%");
              else if($value["operator"] == "eq")
                $connect->whereDate($value["property"],'=',$value["value"]);
              else if($value["operator"] == "gt")
                $connect->whereDate($value["property"],'>=',$value["value"]);
              else if($value["operator"] == "lt")
                $connect->whereDate($value["property"],'<=',$value["value"]);
              }
        }

        // ============ GROUP =============
        // group by (able more than group field)
        // note : please mind the field table selected
        /*
        "groupby":["field","other field"]
        */
        if(!empty($input["groupby"])) {
            if(is_array($input["groupby"])){
                $datagroup = "";             
                foreach($input["groupby"]as $group){
                    $datagroup .= $group.",";
                }
                $arrGroup = substr($datagroup,0,-1);
                $connect->groupByRaw(strtoupper($arrGroup));
            }            
            
            $connect->groupBy(strtoupper($input["groupby"]));            
        }

        // ============= OERDER ===============
        // order by (able more tahn one order by)
        /*
        "orderby":[
            ["field","DESC"],
            ["other field", "ASC"]
        ]
        */
        if(!empty($input["orderby"][0])) {
            $arrOrderby = $input["orderby"];
            if(is_array($arrOrderby[0])){
                foreach($arrOrderby as $in){
                    $connect->orderby($in[0], $in[1]);
                }
            }else{
                $connect->orderby($arrOrderby[0], $arrOrderby[1]);
            }
        }

        $count    = $connect->count();
        //  pagging data
        /*
        "start":"start data",
	    "limit":"value per page"
        */
        if (!empty($input['start'])) {            
            if (!empty($input['limit'])) {
                $connect->skip($input['start'])->take($input['limit']);
            }            
        }
        

        $result   = $connect->get();

        //to show query generate
        // dd(DB::getQueryLog());

        return ["result"=>$result, "count"=>$count];
    }

    public static function insert($input){
        // insert parameter
        // if at data inserted field pk(primary key), so before insert data will be check first
        /*
        "action":"insert",
        "db":"mysql",
        "table":"posts",
        "pk": "id",
        "data" :[
            {
                "title" : "sample title4",
                "body"  : "sample body4",
                "views" : "1"
            }
        ]
        */
        $data       = $input['data'];
        $connect    = DB::connection($input["db"])->table($input["table"]);
        $fieldKey   = $input["pk"];
        foreach ($data as $data) {
            if(isset($data[$fieldKey])){
                $cek = $connect->where($fieldKey, $data[$fieldKey])->get();
                if (empty($cek)) {
                    $insert = $connect->insert($data);
                    return ["msg" => "success","result"=>$data, "key"=>$id];
                }else{
                    return ["msg" => "exist","result"=>$data];
                }
            }else{
                $insert = $connect->insert($data);
                $id = DB::getPdo()->lastInsertId();
                return ["msg" => "success","result"=>$data, "key"=>$id];
            }
        }
    }

    public static function update($input){
        //initial query generate to show
        // update parameter
        /*
        "action":"update",
        "db":"mysql",
        "table":"posts",
        "data" :{
                "title" : "sample title4",
                "body"  : "sample body5",
                "views" : "1"
        },
        "where" :{
                "id" : "5"
        }
        */
        DB::enableQueryLog();

        $data       = $input['data'];
        $connect    = DB::connection($input["db"])->table($input["table"]);
        

        // where parameter
        /* 
        "where": {
            "field" : "value"
        }
        */
        if(!empty($input["where"])) {
            $connect->where($input["where"]);
        }

        // where in parameter (able more than one where in paramaeters)
        /*
        "whereIn": [        
            ["field", ["value","value"]],
            ["other field",["value","value","value"]]        
        ]
       */
        if(!empty($input["whereIn"][0])) {
            $arrWhere = $input["whereIn"];
            if(is_array($arrWhere[0])){
                foreach($arrWhere as $in){       
                    $connect->whereIn(strtoupper($in[0]), $in[1]);
                }
            }else{                
                $connect->whereIn(strtoupper($arrWhere[0]), $arrWhere[1]);
            }
        }

        // where not in parameter (able more than one where not in paramaeters)
        /*
        "whereNotIn": [        
            ["field", ["value","value"]],
            ["other field",["value","value","value"]]        
        ]
       */
        if(!empty($input["whereNotIn"][0])) {
            $arrWhere = $input["whereNotIn"];
            if(is_array($arrWhere[0])){
                foreach($arrWhere as $in){ 
                    $connect->whereNotIn(strtoupper($in[0]), $in[1]);
                }
            }else{                
                $connect->whereNotIn(strtoupper($arrWhere[0]), $arrWhere[1]);
            }
        }
      
        // dd('sini');
        $connect->update($data);
        $data = $connect->get();

        //to show query generate
        // dd(DB::getQueryLog());
        
        return ["msg"=>"Success", "result"=>$data];
    }

    public static function delete($input){
        //initial query generate to show
        // insert parameter
        /*
        "action":"delete",
        "db":"mysql",
        "table":"posts",
        "where" :{
            "id" : "7"
        }
        */
        DB::enableQueryLog();

        $connect    = DB::connection($input["db"])->table($input["table"]);
        

        // where parameter
        /* 
        "where": {
            "field" : "value"
        }
        */
        if(!empty($input["where"])) {
            $connect->where($input["where"]);
        }

        // where in parameter (able more than one where in paramaeters)
        /*
        "whereIn": [        
            ["field", ["value","value"]],
            ["other field",["value","value","value"]]        
        ]
       */
        if(!empty($input["whereIn"][0])) {
            $arrWhere = $input["whereIn"];
            if(is_array($arrWhere[0])){
                foreach($arrWhere as $in){       
                    $connect->whereIn(strtoupper($in[0]), $in[1]);
                }
            }else{                
                $connect->whereIn(strtoupper($arrWhere[0]), $arrWhere[1]);
            }
        }

        // where not in parameter (able more than one where not in paramaeters)
        /*
        "whereNotIn": [        
            ["field", ["value","value"]],
            ["other field",["value","value","value"]]        
        ]
       */
        if(!empty($input["whereNotIn"][0])) {
            $arrWhere = $input["whereNotIn"];
            if(is_array($arrWhere[0])){
                foreach($arrWhere as $in){ 
                    $connect->whereNotIn(strtoupper($in[0]), $in[1]);
                }
            }else{                
                $connect->whereNotIn(strtoupper($arrWhere[0]), $arrWhere[1]);
            }
        }
      
        // dd('sini');
        $data = $connect->get();
        $connect->delete();

        //to show query generate
        // dd(DB::getQueryLog());
        
        return ["msg"=>"Success", "result"=>$data];
    }
}