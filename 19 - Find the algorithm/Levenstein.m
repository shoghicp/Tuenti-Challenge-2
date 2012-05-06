%Levenstein coding
%Marcos Bolanos
%Michigan State University
%December 9, 2011

%This code implements the Levenstein universal coding method. It is not an
%efficient coding scheme but might find some uses where the probability
%distribution of symbols are not known.

function[binarycode]=Levenstein(integer)

n=integer;
stop=0;
binarycode=[];
C=1;

%---------------------------
if n==0
   binarycode=0;
else

b =fliplr(de2bi(n));
if b(1)==1
    b(1)=[];
end
binarycode=[b binarycode];
M=length(b);
%----------------------------
while stop~=1
    
if M~=0
    C=C+1;
    n=M;
    b =fliplr(de2bi(n));
if b(1)==1
    b(1)=[];
end
binarycode=[b binarycode];
M=length(b);

else
    binarycode=[ones(1,C) 0 binarycode];
    stop=1;
end
end
end

