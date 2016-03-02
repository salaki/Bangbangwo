<?php
// class pagination, no code else.  All the fucnctions is using for pagination.this is a common class . all the functions are interlinked


class Paging{
    public $TotalRecord, $TotalPage, $DataDiv, $PageNo, $PerPageRecord, $PerPageLink, $StartRecord, $EndRecord, $QueryString, $PhpSelf;
   
    function firstPage()
    {
        if($this->PageNo==1){
            return '<span class="disabled">First</span>';
        }else{
                        if($this->DataDiv=='STATIC_PAGING')
                            return '<a href="'.$this->QueryString.'/1'.$this->AfterPage.'">First</a>';
                        elseif($this->DataDiv=='')
                            return '<a href="'.$this->PhpSelf.'?page=1'.$this->QueryString.'">First</a>';
                        else
                            return '<a href="javascript:void(0);" onclick="pagingAjax(this, \''.$this->QueryString.'&page=1\', \''.$this->DataDiv.'\');">First</a>';
        }
    }
   
    function lastPage()
    {
        if($this->PageNo == $this->TotalPage){
            return '<span class="disabled">Last</span>';
        }else{
                        if($this->DataDiv=='STATIC_PAGING')
                            return '<a href="'.$this->QueryString.'/'.$this->TotalPage.$this->AfterPage.'">Last</a>';
                        elseif($this->DataDiv=='')
                            return '<a href="'.$this->PhpSelf.'?page='.$this->TotalPage.$this->QueryString.'">Last</a>';
                        else
                            return '<a href="javascript:void(0);" onclick="pagingAjax(this, \''.$this->QueryString.'&page='.$this->TotalPage.'\', \''.$this->DataDiv.'\');">Last</a>';
        }
    }
   
    function nextPage()
    {
        if($this->PageNo >= $this->TotalPage){
            return '<span class="next disabled">Next &raquo;</span>';
        }else{
            $pg = $this->PageNo+1;
                        if($this->DataDiv=='STATIC_PAGING')
                            return '<a class="next" href="'.$this->QueryString.'/'.$pg.$this->AfterPage.'">Next &raquo;</a>';
                        elseif($this->DataDiv=='')
                            return '<a class="next" href="'.$this->PhpSelf.'?page='.$pg.$this->QueryString.'">Next &raquo;</a>';
                        else
                            return '<a class="next" href="javascript:void(0);" onclick="pagingAjax(this, \''.$this->QueryString.'&page='.$pg.'\', \''.$this->DataDiv.'\');">Next &raquo;</a>';
        }
    }
   
    function previousPage()
    {
        if($this->PageNo == 1){
            return '<span class="prev disabled">&laquo; Prev</span>';
        }else{
            $pg = $this->PageNo-1;
                        if($this->DataDiv=='STATIC_PAGING')
                            return '<a class="prev" href="'.$this->QueryString.'/'.$pg.$this->AfterPage.'" >&laquo; Prev</a>';
                        elseif($this->DataDiv=='')
                            return '<a class="prev" href="'.$this->PhpSelf.'?page='.$pg.$this->QueryString.'">&laquo; Prev</a>';
                        else
                            return '<a class="prev" href="javascript:void(0);" onclick="pagingAjax(this, \''.$this->QueryString.'&page='.$pg.'\', \''.$this->DataDiv.'\');">&laquo; Prev</a>';
        }
    }
   
    function chkPageNo($PageNo=1, $SelectQuery='', $PerPageRecord=10, $PerPageLink=5, $QueryString='', $TotalPage='', $DataDiv='', $AfterPage='')
    {
        if(!$PageNo || $PageNo<=0) { $PageNo=1;    }
        if($PerPageRecord){ $this->PerPageRecord = $PerPageRecord; }
        if($PerPageLink){ $this->PerPageLink = $PerPageLink; }
       
        $this->PageNo=$PageNo;
        $this->QueryString = $QueryString;
        $this->AfterPage = $AfterPage;
        $this->PhpSelf = htmlspecialchars($_SERVER['PHP_SELF']);
        $this->DataDiv = $DataDiv;
        $sql_query1 = mysql_query($SelectQuery);
        $this->TotalPage = mysql_num_rows($sql_query1);
        $this->TotalRecord = $this->TotalPage;
       
        $this->TotalPage = floor($this->TotalRecord / $this->PerPageRecord);
        if($this->TotalRecord % $this->PerPageRecord != 0){
            $this->TotalPage+= 1;
        }
        if($TotalPage && $TotalPage < $this->TotalPage){
            $this->TotalPage = $TotalPage;
        }
        if($this->PerPageLink%2==0){
            $page=floor($this->PerPageLink/2);
        } else{
            $page=floor($this->PerPageLink/2);
            $page++;
        }
        if($this->PageNo >= $this->TotalPage){
            $this->PageNo = $this->TotalPage;
        }
        /*/////////////////////////////////////////////////////////////////////////////////*/       
        if($this->PageNo <= 1 || ($this->PageNo <= $page && $this->TotalRecord > $this->PerPageLink)){        // page=PerPage(10)/2 => 5
            $this->StartRecord = 1;
            $this->EndRecord = $this->PerPageLink;    //5
        }
        else if($this->TotalPage <= $this->PerPageLink){
            $this->StartRecord=1;
            $this->EndRecord=$this->TotalPage;           
        }
        else if($this->PageNo >= $this->TotalPage){
            $this->StartRecord=$this->TotalPage-$page;
            $this->EndRecord=$this->TotalPage;
        }
        else{
            $this->StartRecord=$this->PageNo - $page + 1;
            $this->EndRecord=$this->PageNo + $page - 1;
        }
        /*/////////////////////////////////////////////////////////////////////////////////*/
        return $this->TotalPage;
    }
   
    function showLink()
    {
                $links='';
        if($this->EndRecord >= $this->TotalPage){    $this->EndRecord = $this->TotalPage;    }
        if($this->EndRecord > $this->PerPageLink){
            //$links = "<a href='$this->PhpSelf?page=$i$this->QueryString"."&p=1'>1</a>... ";
        }
        for($i=$this->StartRecord; $i<=$this->EndRecord; $i++){
            if($this->PageNo==$i){
                $links .= '<span class="current">'.$i.' <span class="selecetPage"></span></span>';
            } else{
                                if($this->DataDiv=='STATIC_PAGING')
                                    $links .= '<a href="'.$this->QueryString.'/'.$i.$this->AfterPage.'" >'.$i.'</a>';
                                elseif($this->DataDiv=='')
                                    $links .= '<a href="'.$this->PhpSelf.'?page='.$i.$this->QueryString.'">'.$i.'</a>';
                                else
                                    $links .= '<a href="javascript:void(0);" onclick="pagingAjax(this, \''.$this->QueryString.'&page='.$i.'\', \''.$this->DataDiv.'\');">'.$i.'</a>';
            }
            $links .= " ";
        }
        if($this->EndRecord < $this->TotalPage){
            //$links .= "...<a href='$this->PhpSelf?page=$i$this->QueryString"."&p=$this->TotalPage'>$this->TotalPage</a>";
        }
        return $links;
    }
   
    function showRecord($SelectQuery,$order='')
    {
        if($this->PageNo > $this->TotalPage){
            $Start = ($this->TotalPage-1)*$this->PerPageRecord;           
        }
        else{           
            $Start = ($this->PageNo-1)*$this->PerPageRecord;       
        }
		if($order != '')
		{
			$order = ' ORDER BY '.$order;
		}
        $Start = intval($Start>0) ? $Start : 0;
         $sql_query = "$SelectQuery $order limit $Start,$this->PerPageRecord";
        
        $sql_query = mysql_query($sql_query);
        return ($sql_query);
    }
   
    function callAll($PageNo=1, $SelectQuery='', $PerPageRecord=10, $PerPageLink=5, $QueryString='', $TotalPage='')
    {
        $this->chkPageNo($PageNo, $SelectQuery, $PerPageRecord, $PerPageLink, $QueryString, $TotalPage);
        return $this->firstPage() ." ". $this->backPage() ." ". $this->showLink() ." ". $this->nextPage() ." ". $this->lastPage();
    }
   
    function showNavigation()
    {
        //return $this->firstPage() ." ". $this->previousPage() ." ". $this->showLink() ." ". $this->nextPage() ." ". $this->lastPage();
                if($this->TotalPage>1) return '<div class="paginationInner">'.$this->previousPage() ." ". $this->showLink() ." ". $this->nextPage().'</div>';
    }
    
      function showNavigation1()
    {
        //return $this->firstPage() ." ". $this->previousPage() ." ". $this->showLink() ." ". $this->nextPage() ." ". $this->lastPage();
                if($this->TotalPage>1) return '<div class="paginationInner1">'.$this->previousPage() ." ". $this->showLink() ." ". $this->nextPage().'</div>';
    }
    
        /*
         * TG NEw Functionalty Pagination With Arrow Buttons
         */
     function showPaging($nxtCls,$prevCls,$currCls,$simpleCls,$disable)
    {
            //SHOW PAGING LIKE 1,2,3,4
            if($this->EndRecord >= $this->TotalPage){    $this->EndRecord = $this->TotalPage;    }
        if($this->EndRecord > $this->PerPageLink){
            //$links = "<a href='$this->PhpSelf?page=$i$this->QueryString"."&p=1'>1</a>... ";
        }
        for($i=$this->StartRecord; $i<=$this->EndRecord; $i++){
            if($this->PageNo==$i){
                $links .= '<span class="'.$currCls.'">'.$i.'<span class="selecetPage"></span></span>';
            } else{   
                                $links .= '<a class="'.$simpleCls.'" href="javascript:void(0);" onclick="commmonFun(\''.$this->QueryString.'&page='.$i.'\', \''.$this->DataDiv.'\');">'.$i.'</a>';
            }
            $links .= " ";
        }
        if($this->EndRecord < $this->TotalPage){
            //$links .= "...<a href='$this->PhpSelf?page=$i$this->QueryString"."&p=$this->TotalPage'>$this->TotalPage</a>";
        }
            //END SHOW PAGING LIKE 1,2,3,4
               
            //SHOW PREVIOUS BUTTON ( > )
            if($this->PageNo >= $this->TotalPage){
                    $nxtPage='<span class="'.$disable.' next">Next</span>';
            }else{
                $pg = $this->PageNo+1;
                $nxtPage='<a class="'.$nxtCls.'" href="javascript:void(0);" onclick="commmonFun(\''.$this->QueryString.'&page='.$pg.'\', \''.$this->DataDiv.'\');">Next</a>';
            }
            //END SHOW PREVIOUS BUTTON ( > )
           
            //SHOW NEXT BUTTON ( > )
            if($this->PageNo == 1){
                    $prvsPAge='<span class="'.$disable.' prev">Prev</span>';
            }else{
                    $pg = $this->PageNo-1;
                        $prvsPAge='<a class="'.$prevCls.'" href="javascript:void(0);" onclick="commmonFun(\''.$this->QueryString.'&page='.$pg.'\', \''.$this->DataDiv.'\');"> Prev</a>';
            }
            //END SHOW NEXT BUTTON ( > )
           

            //return $this->firstPage() ." ". $this->previousPage() ." ". $this->showLink() ." ". $this->nextPage() ." ". $this->lastPage();
            if($this->TotalPage>1) return $prvsPAge ." ". $links ." ". $nxtPage;
    }
        /*
         * END TG NEw Functionalty Pagination With Arrow Buttons
         */
       
         function __pagination($url, $totalPages, $pNo) {
            // Pagging
            $nextPNo = ($pNo + 1);
            $prevPNo = ($pNo - 1);
            if ($totalPages < 5)
                $style = 'style="padding-left:280px;"';
            else
                $style = '';

            $resultTable = ' <div class="paginationInner">';
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($pNo > 1 && $totalPages > 1)
                    $resultTable .= '<a href="' . $url . $prevPNo . '" class="prev">&laquo; Prev</a>';
                else
                    $resultTable .= '<span class="prev disabled">&laquo; Prev</span>';
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($pNo == $i)
                        $class = "class=current"; else
                        $class = "class=''";
                    if ($totalPages > 15) {
                        if ($pNo >= 10) {
                            $stPageNo = ($pNo - 5);
                            $endPageNo = ($pNo + 5);
                            if ($endPageNo > $totalPages) {
                                $extra = ($endPageNo - $totalPages);
                                $stPageNo -= $extra;
                            }
                        } else {
                            $stPageNo = 1;
                            $endPageNo = 10;
                        }
                        if ($i >= $stPageNo && $i <= $endPageNo) {
                            if ($pNo == $i)
                                $resultTable .= '<span ' . $class . '>' . $i . '<span class="selecetPage"></span></span>';
                            else
                                $resultTable .= '<a href="' . $url . $i . '">' . $i . '</a>';
                            $showPStEnd = $i;
                        }
                    }else {
                        if ($pNo == $i)
                            $resultTable .= '<span ' . $class . '>' . $i . '<span class="selecetPage"></span></span>';
                        else
                            $resultTable .= '<a href="' . $url . $i . '">' . $i . '</a>';
                    }
                }
                if ($pNo < $totalPages && $totalPages > 1)
                    $resultTable .= '<a href="' . $url . $nextPNo . '" class="next">Next &raquo;</a>';
                else
                    $resultTable .= '<span class="next disabled">Next &raquo;</span>';
            }
            $resultTable .= '</div>';
            return $resultTable;
            // Pagging
        }
   
} //class end
