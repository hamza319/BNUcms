# BNUcms

This system uses bootstrap, jQuerry libraries. 

#Classes:
1. User
2. Student
3. Faculty
4. Mailbox
5. C-R
6. Received
7. Sent
8. Responses

1.User:
      That is the base class for Student and Faculty. Student and faculty are childs of this class.
4. Mailbox:
      Mailbox class takes all complaints in the system and load compalints relavent to the user into Sent,Recieved and Response classes. The system then acceses those classes to view complaints in their respective "inboxes".
6.7.8: Received.Sent.Response:
      These are the "inboxes" that mailbox populates with complants with the relavent flags.
5.C-R:
      This is the class for a complaint/Request.
