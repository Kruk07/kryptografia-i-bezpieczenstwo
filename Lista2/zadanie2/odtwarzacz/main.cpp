#include <iostream>
#include <fstream>
#include<conio.h>
#include "C:\bass\c\bass.h"
#pragma comment( lib, "C:\\bass\\c\\bass.lib" )

#include <stdio.h>
#include <stdlib.h>
#include <sys/stat.h>

using namespace std;

using std::cout;
using std::cin;
using std::string;




void play(string sciezka){

HSTREAM strumien;
DWORD dwStreamLen;
DWORD dwStreamCurrentPos;
float fSeconds;
float fSecondsTotal;



		//inicjacja BASS'a
	if (!BASS_Init(-1, 44100, 0, 0, 0))  //urzadzenie domyslne dzwieku
	{
		BASS_Init(0, 44100, 0, 0, 0);  //blad, to bez dzwieku
		cout << "Blad";
	}
		cout << "\nOdtwarzanie...";
		//tworzenie strumienia dzwieku
	strumien = BASS_StreamCreateFile(false, sciezka.c_str(), 0, 0, 0);

		dwStreamLen = BASS_ChannelGetLength(strumien,BASS_POS_BYTE);
	fSecondsTotal = BASS_ChannelBytes2Seconds(strumien, dwStreamLen);
        int sekundyT=(int)fSecondsTotal;
        int minutyT= sekundyT/60;
        int sekundy2T=sekundyT%60;

    bool play;
    play=true;





	BASS_ChannelPlay(strumien, true);  //start odtwarzania strumienia
do
{
		dwStreamCurrentPos = BASS_ChannelGetPosition(strumien,BASS_POS_BYTE);
		fSeconds = BASS_ChannelBytes2Seconds(strumien, dwStreamCurrentPos);
        int sekundy=(int)fSeconds;
        int minuty= sekundy/60;
        int sekundy2=sekundy%60;
        char charss;

        charss=_getch();
        if (charss=='p'){
                if(play){
                    BASS_ChannelPause(strumien);
                    play=false;
                }
                else{
                    BASS_ChannelPlay(strumien, false);
                    play=true;
                }

        }
        if (charss=='r'){

            BASS_ChannelPlay(strumien, true);
        }
        if (charss==']'){
            QWORD x=BASS_ChannelGetPosition(strumien, BASS_POS_BYTE);
            x+=1000000;
            BASS_ChannelSetPosition(strumien,x, BASS_POS_BYTE);
        }
        if (charss=='['){
            QWORD x=BASS_ChannelGetPosition(strumien, BASS_POS_BYTE);
            x-=1000000;
            BASS_ChannelSetPosition(strumien,x, BASS_POS_BYTE);
        }
        if (charss=='x'){
            break;
        }
        //printf("\rSeconds: %d:%d /%d:%d ", minuty,sekundy2,minutyT,sekundy2T);


    Sleep(10);
    //system("cls");
	}while(BASS_ChannelIsActive(strumien));  //odtwarzanie do konca pliku
		BASS_Stop();
	BASS_Free();


}
void decoding(string zaszyfrowane4,string sciezka,string idklucza,string haslo,string haslo2){
    string console= "java -jar coding.jar D "+zaszyfrowane4+" temp.mp3 cbc "+sciezka+" "+haslo+" "+haslo2+" "+idklucza+" -";
    int number=system(console.c_str());
    play("temp.mp3");
    remove("temp.mp3");
}

void validate(string pin,string zaszyfrowane3){
    if(pin==""){
        cout << "\nWprowadŸ PIN:";
        getline(cin, pin);
    }
    string console= "java -jar coding.jar D config.conf config2.txt gcm - - - - " +pin;
    int number=system(console.c_str());
    if(number!=0){
        cout<<"\nBledny PIN";
        system("pause");
        exit(-1);
    }
	ifstream plik;
    plik.open( "config2.txt", ios::out );
    string sciezka;
    string idklucza;
    string haslo;
    string haslo2;
    getline(plik,sciezka);
    getline(plik,haslo);
    getline(plik,idklucza);
    getline(plik,haslo2);
    plik.close();
    remove("config2.txt");
    cout<<"\nWczytano poprawnie dane. Trwa uruchamianie...";
    decoding(zaszyfrowane3,sciezka,idklucza,haslo,haslo2);
}
string create(){
    string pin;
    string sciezka;
    string idklucza;
    string haslo;
    string haslo2;
    cout << "WprowadŸ PIN: ";
	getline(cin, pin);
    cout << "WprowadŸ sciezke do pliku .jck: ";
	getline(cin, sciezka);
    cout << "WprowadŸ haslo: ";
	getline(cin, haslo);
    cout << "WprowadŸ alias: ";
	getline(cin, idklucza);
    cout << "WprowadŸ haslo do klucza: ";
	getline(cin, haslo2);

	//cout <<pin;
    //cout <<sciezka;
	//cout <<idklucza;
	//cout <<haslo;
	fstream plik;
    plik.open( "config.txt", ios::out );
    plik << sciezka << endl;
    plik << haslo << endl;
    plik << idklucza << endl;
    plik << haslo2 << endl;
    plik.close();
    string console= "java -jar coding.jar E config.txt config.conf gcm - - - - " +pin;
    system(console.c_str());
    remove("config.txt");
    cout<< "\nUtworzono plik config.conf";
    return pin;
}

int fileExists (const char* fileName)
{
        struct stat buf;
        if ( stat(fileName, &buf) == 0 )
            return 1;
        else
            return 0;
}

void conf(string zaszyfrowane2){

        if ( fileExists("config.conf") ){
            cout<<("Znaleziono plik config!\n");
            validate("",zaszyfrowane2);
        }
        else{
            cout<<("Plik nie istnieje!\n");
            string pass =create();
            validate(pass,zaszyfrowane2);
        }

}

int main()
{
    string zaszyfrowane;
        cout << "Podaj nazwe pliku do zdeszyfrowania: ";
	getline(cin, zaszyfrowane);

    conf(zaszyfrowane);
		system("PAUSE");
	return EXIT_SUCCESS;
}
