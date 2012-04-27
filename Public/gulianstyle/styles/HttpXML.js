function httpRequest(method,data,URL,Async)
{
	/*var Http = new ActiveXObject("Microsoft.XMLHTTP"); //建立XMLHTTP对象
	Http.open(method,URL,false);
	Http.send(data);
	var response = Http.responseText;
	delete(Http);

	return response;*/
	if (Async == undefined) Async = false;
	var Http = null;
	try { 
		Http = new ActiveXObject("Msxml2.XMLHTTP"); 
	} 
	catch(e) { 
		try { 
			Http = new ActiveXObject("Microsoft.XMLHTTP"); 
		}
		catch(oc) { 
				Http = null; 
		}
	}
	if (!Http && window.XMLHttpRequest) { 
		Http = new XMLHttpRequest();
	}
	if (Http == null) {
		alert("Your browser cannot handle this script,you can try IE or Firefox.");
	}
	Http.open(method,URL,Async);
	if (!Async) {
		Http.send(data);
		var response = Http.responseText;
		delete(Http);
		return response;
	}
	else {
		return Http;
	}
}


function XMLDatastore()
{
	//类变量
	var xmlDoc;
	var errorInfo;
	var listOfNodes;

	//类方法
	this.getListOfNodes = getListOfNodes;
	this.init = init;
	this.createNew = createNew;
	this.loadFile = loadFile;
	this.loadXML = loadXML;
	this.rowCount = rowCount;
	this.colCount = colCount;
	this.getItem = getItem;
	this.getItemByName = getItemByName;
	this.insertRow = insertRow;
	this.addColumn = addColumn;
	this.setItem = setItem;
	this.setItemByName = setItemByName;
	this.getItemXmlByName = getItemXmlByName;
	this.getXML = getXML;
	this.getErrorInfo = getErrorInfo;
	this.destroy = destroy;

	function getListOfNodes() {
		return listOfNodes;
	}
	function init()
	{
		// code for IE
		if (window.ActiveXObject)
		{
			xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.async=false;
		}
		// code for Mozilla, Firefox, Opera, etc.
		else if (document.implementation && document.implementation.createDocument)
		{
			xmlDoc = document.implementation.createDocument('', '', null);
			xmlDoc.async=false;
		}
		else
		{
			alert('Your browser cannot handle this script,you can try IE or Firefox.');
		}

	}

	function createNew()
	{
		root = xmlDoc.createElement("rows");
		xmlDoc.appendChild(root);
		listOfNodes = xmlDoc.documentElement.childNodes;
	}


	function loadFile(fileName)
	{
		var result = false;
		
		xmlDoc.load(fileName);
		
		root = xmlDoc.getElementsByTagName(xmlDoc.childNodes[0].tagName)[0];
		if (root.childNodes[1] == null) {
			listOfNodes = xmlDoc.documentElement.childNodes;
		}
		else {
			listOfNodes = root.getElementsByTagName(root.childNodes[1].tagName);
		}
		result = true;
		return result;
	}

	function loadXML(xml)
	{
		var result = false;
		if (navigator.appName.indexOf("Internet Explorer") == -1) {
			var parser=new DOMParser();
			xmlDoc=parser.parseFromString(xml,"text/xml");
			if (xmlDoc.documentElement) {
				result = true;
				listOfNodes = xmlDoc.documentElement.childNodes;
			}
		}
		else {
			xmlDoc.loadXML(xml);
			if(xmlDoc.parseError !=0)
			errorInfo = xmlDoc.parseError.reason;
			else
			{
				result = true;
				listOfNodes = xmlDoc.documentElement.childNodes;
			}
		}

		return result;
	}

	function rowCount()
	{
		return listOfNodes.length;
	}

	function colCount()
	{
		var cols = 0;

		if(rowCount()>0)
			cols = listOfNodes.item(0).childNodes.length;

		return cols;
	}

	function getItem(rowNo,colNo)
	{
		var node = listOfNodes.item(rowNo);
		node = node.childNodes.item(colNo);

		if (node.text != undefined) {
			return node.text;
		}
		else {
			return node.textContent;
		}
	}
	
	function getItemXml(rowNo,colNo)
	{
		var node = listOfNodes.item(rowNo);
		node = node.childNodes.item(colNo);
		xml = "";
		if (node.xml != undefined) {
			xml = node.xml;
		}
		else if (typeof XMLSerializer != 'undefined'){
			xml = (new XMLSerializer()).serializeToString(node);
		}
		return xml.replace("<"+node.nodeName+">","").replace("</"+node.nodeName+">","");
	}

	function getItemByName(rowNo,colName)
	{
		var node = listOfNodes.item(rowNo);
		if (node == undefined)
			return "";
		var rowNodes = node.childNodes;
		var i;
		for(i=0;i<rowNodes.length;i++)
		{
			node = rowNodes.item(i);
			if(node.tagName == colName) {
				if (node.text != undefined) {
					return node.text;
				}
				else {
					return node.textContent;
				}
			}
		}

	}
	
	function getItemXmlByName(rowNo,colName)
	{
		var node = listOfNodes.item(rowNo);
		if (node == undefined)
			return "";
		var rowNodes = node.childNodes;
		var i;
		for(i=0;i<rowNodes.length;i++)
		{
			node = rowNodes.item(i);
			if(node.tagName == colName) {
				xml = "";
				if (node.xml != undefined) {
					xml = node.xml;
				}
				else if (typeof XMLSerializer != 'undefined'){
					xml = (new XMLSerializer()).serializeToString(node);
				}
				return xml.replace("<"+node.nodeName+">","").replace("</"+node.nodeName+">","");
			}
		}
	}

	function insertRow(rowNo)
	{
		var rowElement = xmlDoc.createElement("row");

		if(rowNo == -1)
		{
			xmlDoc.documentElement.appendChild(rowElement);
			rowNo = rowCount();
		}
		else
		{
			xmlDoc.documentElement.insertBefore(rowElement,listOfNodes.item(rowNo));
		}

		return rowNo;
	}

	function addColumn(rowNo,colName,value)
	{
		var colElement = xmlDoc.createElement(colName);
		var node = listOfNodes.item(rowNo);
		node.appendChild(colElement);
		node.lastChild.text = value;
	}

	function setItem(rowNo,colNo,value)
	{
		var node = listOfNodes.item(rowNo);
		node = node.childNodes.item(colNo);

		return node.text = value;
	}

	function setItemByName(rowNo,colName,value)
	{
		var listOfCols = xmlDoc.documentElement.getElementsByTagName(colName);
		var node = listOfCols.item(rowNo);

		return node.text = value;
	}

	function getXML()
	{
		/*if (window.XSLTProcessor) {
			// transformToDocument方式
			var xsltProcessor = new XSLTProcessor();
			//xmlDoc.load("../XmlFile/Common.xsl");
			xsltProcessor.importStylesheet("../XmlFile/Common.xsl");
			var result = xsltProcessor.transformToDocument(xmlDoc);
			var xmls = new XMLSerializer();
			return xmls.serializeToString(result);
		}
		else {
			return xmlDoc.transformNode(xmlDoc);
		}*/
		var xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		xmlstr += "<rows>";
		for (i=0; i<listOfNodes.length; i++) {
			xmlstr += "<row>";
			rowNodes = listOfNodes.item(i).childNodes;
			for(j=0;j<rowNodes.length;j++)
			{
				node = rowNodes.item(j);
				xmlstr += "<"+node.tagName+">";
				if (node.text != undefined) {
					xmlstr += node.text;
				}
				else {
					xmlstr += node.textContent;
				}
				xmlstr += "</"+node.tagName+">";
			}
			xmlstr += "</row>";
		}
		xmlstr += "</rows>";
		return xmlstr;
	}

	function getErrorInfo()
	{
		return errorInfo;
	}

	function destroy()
	{
		delete(xmlDoc);
	}
}
