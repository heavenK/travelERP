<?php
class Email {
    var $mailTo = ""; // 收件人
    var $mailCC = ""; // 抄送
    var $mailBCC = ""; // 秘密抄送
    var $mailFrom = ""; // 发件人
    var $mailSubject = ""; // 主题
    var $mailText = ""; // 文本格式的信件主体
    var $mailHTML = ""; // html格式的信件主体
    var $mailAttachments = ""; // 附件

    function setTo($inAddress) {
        $addressArray = explode( ",",$inAddress);
        for($i=0;$i<count($addressArray);$i++){ if($this->checkEmail($addressArray[$i])==false) return false; }
        $this->mailTo = implode($addressArray, ",");
        return true;
    }

    function setCC($inAddress){
        $addressArray = explode( ",",$inAddress);
        for($i=0;$i<count($addressArray);$i++){ if($this->checkEmail($addressArray[$i])==false) return false; }
        $this->mailCC = implode($addressArray, ",");
        return true;
    }

    function setBCC($inAddress){
        $addressArray = explode( ",",$inAddress);
        for($i=0;$i<count($addressArray);$i++) {
            if($this->checkEmail($addressArray[$i])==false)
            return false;
        }
        $this->mailBCC = implode($addressArray, ",");
        return true;
    }

    function setFrom($inAddress){
        if($this->checkEmail($inAddress)){
            $this->mailFrom = $inAddress;
            return true;
        }
        return false;
    }

    function setSubject($inSubject){
        if(strlen(trim($inSubject)) > 0){
            $this->mailSubject = ereg_replace( "n", "",$inSubject);
            return true;
        }
        return false;
    }

    function setText($inText){
        if(strlen(trim($inText)) > 0){
            $this->mailText = $inText;
            return true;
        }
        return false;
    }

    function setHTML($inHTML){
        if(strlen(trim($inHTML)) > 0){
            $this->mailHTML = $inHTML;
            return true;
        }
        return false;
    }

    function setAttachments($inAttachments){
        if(strlen(trim($inAttachments)) > 0){
            $this->mailAttachments = $inAttachments;
            return true;
        }
        return false;
    }

    function checkEmail($inAddress){
        return (ereg( "^[^@ ]+@([a-zA-Z0-9-]+.)+([a-zA-Z0-9-]{2}|net|com|gov|mil|org|edu|int)$",$inAddress));
    }

    function loadTemplate($inFileLocation,$inHash,$inFormat){
        $templateDelim = "~";
        $templateNameStart = "!";
        $templateLineOut = "";
        if($templateFile = fopen($inFileLocation, "r")){
            while(!feof($templateFile)){
                $templateLine = fgets($templateFile,1000);
                $templateLineArray = explode($templateDelim,$templateLine);
                for( $i=0; $i<count($templateLineArray);$i++){
                    if(strcspn($templateLineArray[$i],$templateNameStart)==0){
                        $hashName = substr($templateLineArray[$i],1);
                        $templateLineArray[$i] = ereg_replace($hashName,(string)$inHash[$hashName],$hashName);
                    }
                }
                $templateLineOut .= implode($templateLineArray, "");
            }
            if( strtoupper($inFormat)== "TEXT" )
            return($this->setText($templateLineOut));
            else if( strtoupper($inFormat)== "HTML" )
            return($this->setHTML($templateLineOut));
        }
        return false;
    }

    function getRandomBoundary($offset = 0){
        srand(time()+$offset);
        return ( "----".(md5(rand())));
    }

    function getContentType($inFileName){
        $inFileName = basename($inFileName);
        if(strrchr($inFileName, ".") == false){
            return "application/octet-stream";
        }
        $extension = strrchr($inFileName, ".");
        switch($extension){
            case ".gif": return "image/gif";
            case ".gz": return "application/x-gzip";
            case ".htm": return "text/html";
            case ".html": return "text/html";
            case ".jpg": return "image/jpeg";
            case ".tar": return "application/x-tar";
            case ".txt": return "text/plain";
            case ".zip": return "application/zip";
            default: return "application/octet-stream";
        }
        return "application/octet-stream";
    }

    function formatTextHeader(){ $outTextHeader = "";
        $outTextHeader .= "Content-Type: text/plain;
        charset=us-asciin";
        $outTextHeader .= "Content-Transfer-Encoding: 7bitnn";
        $outTextHeader .= $this->mailText. "n";
        return $outTextHeader;
    }

    function formatHTMLHeader(){
        $outHTMLHeader = "";
        $outHTMLHeader .= "Content-Type: text/html;
        charset=us-asciin";
        $outHTMLHeader .= "Content-Transfer-Encoding: 7bitnn";
        $outHTMLHeader .= $this->mailHTML. "n";
        return $outHTMLHeader;
    }

    function formatAttachmentHeader($inFileLocation){
        $outAttachmentHeader = "";
        $contentType = $this->getContentType($inFileLocation);
        if(ereg( "text",$contentType)){
            $outAttachmentHeader .= "Content-Type: ".$contentType. ";n";
            $outAttachmentHeader .= ' name="'.basename($inFileLocation). '"'. "n";
            $outAttachmentHeader .= "Content-Transfer-Encoding: 7bitn";
            $outAttachmentHeader .= "Content-Disposition: attachment;n";
            $outAttachmentHeader .= ' filename="'.basename($inFileLocation). '"'. "nn";
            $textFile = fopen($inFileLocation, "r");
            while(!feof($textFile)){
                $outAttachmentHeader .= fgets($textFile,1000);
            }
            $outAttachmentHeader .= "n";
        }else{
            $outAttachmentHeader .= "Content-Type: ".$contentType. ";n";
            $outAttachmentHeader .= ' name="'.basename($inFileLocation). '"'. "n";
            $outAttachmentHeader .= "Content-Transfer-Encoding: base64n";
            $outAttachmentHeader .= "Content-Disposition: attachment;n";
            $outAttachmentHeader .= ' filename="'.basename($inFileLocation). '"'. "nn";
            exec( "uuencode -m $inFileLocation nothing_out",$returnArray);
            for ($i = 1; $i<(count($returnArray)); $i++){
                $outAttachmentHeader .= $returnArray[$i]. "n";
            }
        }
        return $outAttachmentHeader;
    }

    function send(){
        $mailHeader = "";
        if($this->mailCC != "")
        $mailHeader .= "CC: ".$this->mailCC. "n";
        if($this->mailBCC != "")
        $mailHeader .= "BCC: ".$this->mailBCC. "n";
        if($this->mailFrom != "")
        $mailHeader .= "FROM: ".$this->mailFrom. "n";
        if($this->mailText != "" && $this->mailHTML == "" && $this->mailAttachments == ""){
            return mail($this->mailTo,$this->mailSubject,$this->mailText,$mailHeader);
        } else if($this->mailText != "" && $this->mailHTML != "" && $this->mailAttachments == ""){
            $bodyBoundary = $this->getRandomBoundary();
            $textHeader = $this->formatTextHeader();
            $htmlHeader = $this->formatHTMLHeader();
            $mailHeader .= "MIME-Version: 1.0n";
            $mailHeader .= "Content-Type: multipart/alternative;n";
            $mailHeader .= ' boundary="'.$bodyBoundary. '"';
            $mailHeader .= "nnn";
            $mailHeader .= "--".$bodyBoundary. "n";
            $mailHeader .= $textHeader;
            $mailHeader .= "--".$bodyBoundary. "n";
            $mailHeader .= $htmlHeader;
            $mailHeader .= "n--".$bodyBoundary. "--";
            return mail($this->mailTo,$this->mailSubject, "",$mailHeader);
        } else if($this->mailText != "" && $this->mailHTML != "" && $this->mailAttachments != ""){
            $attachmentBoundary = $this->getRandomBoundary();
            $mailHeader .= "Content-Type: multipart/mixed;n";
            $mailHeader .= ' boundary="'.$attachmentBoundary. '"'. "nn";
            $mailHeader .= "This is a multi-part message in MIME format.n";
            $mailHeader .= "--".$attachmentBoundary. "n";
            $bodyBoundary = $this->getRandomBoundary(1);
            $textHeader = $this->formatTextHeader();
            $htmlHeader = $this->formatHTMLHeader();
            $mailHeader .= "MIME-Version: 1.0n";
            $mailHeader .= "Content-Type: multipart/alternative;n";
            $mailHeader .= ' boundary="'.$bodyBoundary. '"';
            $mailHeader .= "nnn";
            $mailHeader .= "--".$bodyBoundary. "n";
            $mailHeader .= $textHeader;
            $mailHeader .= "--".$bodyBoundary. "n";
            $mailHeader .= $htmlHeader;
            $mailHeader .= "n--".$bodyBoundary. "--";
            $attachmentArray = explode( ",",$this->mailAttachments);
            for($i=0;$i<count($attachmentArray);$i++){
                $mailHeader .= $this->formatAttachmentHeader($attachmentArray[$i]);
            }
            $mailHeader .= "--".$attachmentBoundary. "--";
            return mail($this->mailTo,$this->mailSubject, "",$mailHeader);
        }
        return false;
    }
}
?>