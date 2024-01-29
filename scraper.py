import requests
from bs4 import BeautifulSoup

def get_city_link() -> str:
    stad = input("Van welke stad wilt u de activiteiten zien? ")
    link = f'https://www.booking.com/attractions/searchresults/nl/{stad}.nl.html?'
    return link

def get_html(url:str):
    try:
        get_html.pg_data = requests.get(url)
    except:
        print("error getting the html data...")

def get_activiteit(raw_data):
    bsObj = BeautifulSoup(raw_data.content, "lxml")
    name_data = bsObj.find_all("h4", class_="css-jv2qn6")

    get_activiteit.name_array = []

    for n in name_data:
        for element in n:
            get_activiteit.name_array.append(element.text.strip())

def get_prijs(raw_data):
    bsObj = BeautifulSoup(raw_data.content, "html.parser")
    prijs_data = bsObj.find_all("div", class_="e1eebb6a1e css-13pzcpe")

    get_prijs.prijs_array = []

    for n in prijs_data:
        for element in n:
            get_prijs.prijs_array.append(element.text.strip())

def get_beoordeling(raw_data):
    bsObj = BeautifulSoup(raw_data.content, "html.parser")
    beoordeling_data = bsObj.find_all("span", class_="a53cbfa6de css-35ezg3")

    get_beoordeling.beoordeling_array = []

    for n in beoordeling_data:
        for element in n:
            get_beoordeling.beoordeling_array.append(element.text.strip())

get_html(get_city_link())
get_activiteit(get_html.pg_data)
get_prijs(get_html.pg_data)
get_beoordeling(get_html.pg_data)

print(get_html.pg_data)
print(get_activiteit.name_array)
print(get_prijs.prijs_array)
print(get_beoordeling.beoordeling_array)